<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewProduct;
use App\Models\Bid;
use App\Models\User;
use App\Models\Team;
use App\Models\ProductDocument;
use App\Notifications\ProductSubmittedNotification;
use App\Notifications\AuctionWonNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = NewProduct::query()->where('status', 'approved');

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(NewProduct $product)
    {
        // Retrieve bids grouped by user ID and sum the bid amounts
        $userBids = Bid::where('product_id', $product->id)
                       ->selectRaw('user_id, sum(amount) as total_amount')
                       ->groupBy('user_id')
                       ->get()
                       ->pluck('total_amount', 'user_id');
    
        // Retrieve highest bid for the product
        $highestBid = Bid::where('product_id', $product->id)
                        ->orderBy('amount', 'desc')
                        ->first();
    
        // Check if auction is active for the product
        $isAuctionActive = $product->isAuctionActive();
    
        // Get remaining time for the auction
        $remainingTime = $product->getEndTime();
    
        // Fetch all users that might have bids
        $userIds = $userBids->keys()->toArray(); // Get user IDs with bids
        $users = User::whereIn('id', $userIds)->get(); // Fetch users based on bid user IDs
    
        return view('products.show', [
            'product' => $product,
            'userBids' => $userBids,
            'highestBid' => $highestBid,
            'isAuctionActive' => $isAuctionActive,
            'remainingTime' => $remainingTime,
            'users' => $users, // Pass users to the view
        ]);
    }

    public function showBids(User $user)
{
    $userBids = $user->bids()->orderBy('created_at', 'desc')->get();

    return view('products.bids_show', compact('user', 'userBids'));
}


    public function placeBid(Request $request, NewProduct $product)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'bid_type' => 'required|in:individual,team',
        ]);

        $amount = $request->input('amount');
        $user = auth()->user();
        $bidType = $request->input('bid_type');

        if ($bidType === 'individual') {
            $userContribution = $user->contributions->sum('amount');

            if ($amount > $userContribution) {
                return redirect()->route('products.show', $product)->with('error', 'Insufficient individual funds to place this bid.');
            }
        } else {
            $team = $user->currentTeam;

            if (!$team) {
                return redirect()->route('products.show', $product)->with('error', 'You are not part of a team.');
            }

            $teamContribution = $team->contributions->sum('amount');

            if ($amount > $teamContribution) {
                return redirect()->route('products.show', $product)->with('error', 'Insufficient team funds to place this bid.');
            }

            if ($user->id !== $team->owner->id) {
                // Notify the team owner for bid approval
                $team->notifyOwner($user, $product, $amount);
                return redirect()->route('products.show', $product)->with('success', 'Bid request sent to the team owner for approval.');
            }
        }

        // Place the bid if all checks pass
        Bid::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'amount' => $amount,
        ]);

        return redirect()->route('products.show', $product)->with('success', 'Bid placed successfully.');
    }

    public function determineWinner(NewProduct $product)
    {
        $highestBid = $product->bids()->orderBy('amount', 'desc')->first();
        if ($highestBid) {
            $winningBidder = $highestBid->user;
            Notification::send($winningBidder, new AuctionWonNotification($product, $highestBid->amount));
        }

        return view('products.winner', compact('product', 'highestBid'));
    }

    public function removeBid(Bid $bid)
    {
        $bid->delete();

        return back()->with('success', 'Bid removed successfully.');
    }

    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|string|in:minutes,hours,days',
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = auth()->user();


        // Handle the image file
        $imagePath = $request->file('image')->store('products', 'public');

        // Calculate the end time based on duration value and unit
        $durationValue = $request->input('duration_value');
        $durationUnit = $request->input('duration_unit');
        $endTime = now();

        switch ($durationUnit) {
            case 'minutes':
                $endTime->addMinutes($durationValue);
                break;
            case 'hours':
                $endTime->addHours($durationValue);
                break;
            case 'days':
                $endTime->addDays($durationValue);
                break;
        }

        // Create a new product and save it in the database
        $product = NewProduct::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath, // Store the image path
            'auction_status' => 'active', // Set default auction status
            'duration' => $durationValue,
            'duration_unit' => $durationUnit,
            'end_time' => $endTime,
            'status' => 'pending',
            'user_id' => $user->id,

        ]);

        // Handle product documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $documentPath = $document->store('product_documents', 'public');
                ProductDocument::create([
                    'new_product_id' => $product->id,
                    'path' => $documentPath,
                ]);
            }
        }

        // Send notification to the user
        $user = auth()->user();
        $user->notify(new ProductSubmittedNotification($product));

        // Check if the product was created successfully
        if ($product) {
            return redirect()->route('products.index')->with('success', 'Product submitted for review.');
        } else {
            Log::error('Failed to create product.', ['request' => $request->all()]);
            return back()->with('error', 'Failed to create product.');
        }
    }
}
