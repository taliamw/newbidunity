<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewProduct;
use App\Models\Bid;

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

        $products = $query->paginate(12); // Adjust the number of items per page as needed

        return view('products.index', compact('products'));
    }


public function show(NewProduct $product)
{
    $bids = $product->bids()->orderBy('amount', 'desc')->get();
    $highestBid = $bids->first();
    $isAuctionActive = $product->isAuctionActive();
    $remainingTime = $product->getEndTime();

    return view('products.show', compact('product', 'bids', 'highestBid', 'isAuctionActive', 'remainingTime'));
}


    public function placeBid(Request $request, NewProduct $product)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        Bid::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'amount' => $request->input('amount'),
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
        // Add authorization logic if needed (e.g., check if user can remove this bid)
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
    NewProduct::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'image' => $imagePath, // Store the image path
        'auction_status' => 'active', // Set default auction status
        'duration' => $request->duration,
        'status' => 'pending,'
    ]);

    // Redirect back to the products page with a success message
    return redirect()->route('products.index')->with('success', 'Product submitted for review.');
}

    

}
