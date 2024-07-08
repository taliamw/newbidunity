<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewProduct;
use Illuminate\Support\Facades\Log;

class AdminListingController extends Controller
{
    public function index()
    {
        $pendingProducts = NewProduct::where('status', 'pending')->get();
        $approvedProducts = NewProduct::where('status', 'approved')->get();
        $rejectedProducts = NewProduct::where('status', 'rejected')->get();
        return view('listing_management', compact('pendingProducts', 'approvedProducts', 'rejectedProducts'));
    }

    public function approve(NewProduct $product)
    {
        $product->update(['status' => 'approved']);
        Log::info('Product approved', ['product_id' => $product->id, 'status' => $product->status]);
        return redirect()->route('listing_management')->with('success', 'Listing approved.');    }

    public function reject(NewProduct $product)
    {
        $product->update(['status' => 'rejected']);
        Log::info('Product rejected', ['product_id' => $product->id, 'status' => $product->status]);
        return redirect()->route('listing_management')->with('success', 'Listing rejected.');    
    }

    public function edit(NewProduct $listing)
    {
        return view('products.edit', compact('listing'));
    }

    // Method to update the listing
    public function update(Request $request, NewProduct $listing)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            // Add more validation rules as per your requirements
        ]);

        $listing->update($request->all());

        return redirect()->route('listing_management')->with('success', 'Listing updated successfully.');
    }

    // Method to delete the listing
    public function destroy(NewProduct $listing)
    {
        $listing->delete();

        return redirect()->route('admin.products.index')->with('success', 'Listing deleted successfully.');
    }
}

