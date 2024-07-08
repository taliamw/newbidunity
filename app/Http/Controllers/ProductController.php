<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewProduct;
use App\Models\Bid;
use App\Models\Team;
use App\Notifications\OutbidNotification;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = NewProduct::query()->where('status', 'approved');;

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $products = $query->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show(NewProduct $product)
{
    $bids = $product->bids()->orderBy('amount', 'desc')->get();
    $highestBid = $bids->first();
    $isAuctionActive = $product->isAuctionActive();
    $remainingTime = $product->end_time; // Assuming end_time is properly formatted as Carbon instance


    return view('products.show', compact('product', 'bids', 'highestBid', 'isAuctionActive', 'remainingTime'));
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

        // Notify previous highest bidder
        $highestBid = $product->bids()->orderBy('amount', 'desc')->first();
        if ($highestBid && $highestBid->user_id !== $user->id) {
            $highestBid->user->notify(new OutbidNotification($product));
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
        'duration' => 'required|integer|min:1',
    ]);

    // Handle the image file
    $imagePath = $request->file('image')->store('products', 'public');

    // Create a new product and save it in the database
    $product = NewProduct::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'image' => $imagePath, // Store the image path
        'auction_status' => 'active', // Set default auction status
        'duration' => $request->duration,
        'status' => 'pending',
    ]);

    // Check if the product was created successfully
    if ($product) {
        return redirect()->route('products.index')->with('success', 'Product submitted for review.');
    } else {
        Log::error('Failed to create product.', ['request' => $request->all()]);
        return back()->with('error', 'Failed to create product.');
    }
}

}
