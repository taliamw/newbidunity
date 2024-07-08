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
        
        $query = NewProduct::query();

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
            'duration_days' => 'required|integer|min:0',
            'duration_hours' => 'required|integer|min:0|max:23',
            'duration_minutes' => 'required|integer|min:0|max:59',
        ]);
    
        // Handle the image file
        $imagePath = $request->file('image')->store('products', 'public');
    
        // Calculate the auction end time
        $duration = $request->input('duration_days') * 1440 + $request->input('duration_hours') * 60 + $request->input('duration_minutes');
    
        // Create a new product and save it in the database
        $product = NewProduct::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'auction_status' => 'active',
            'duration' => $duration, // Store the duration
            'status' => 'pending', // or any default status
            'end_time' => now()->addDays($duration), // Ensure this calculation is correct
        ]);
    
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }
    
}
