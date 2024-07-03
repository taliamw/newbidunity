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
        
        $query = NewProduct::query();

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
        
        // Determine the winning bid (highest bid)
        $winningBid = $bids->first(); // Adjust this logic as needed

        return view('products.show', compact('product', 'bids', 'winningBid'));
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
}
