<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ListingRejected;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ListingApproved;

class AdminListingController extends Controller
{
    public function index()
    {
        $this->authorize("viewAny", User::class);

        $pendingProducts = NewProduct::where('status', 'pending')->get();
        $approvedProducts = NewProduct::where('status', 'approved')->get();
        $rejectedProducts = NewProduct::where('status', 'rejected')->get();
        return view('listing_management', compact('pendingProducts', 'approvedProducts', 'rejectedProducts'));
    }

    public function approve(NewProduct $product)
    {
        $product->update(['status' => 'approved']);
        Log::info('Product approved', ['product_id' => $product->id, 'status' => $product->status]);

        $product->user->notify(new ListingApproved($product));

        return redirect()->route('listing_management')->with('success', 'Listing approved.');    }

    public function reject(NewProduct $product, Request $request)
    {
        $product->update(['status' => 'rejected']);
        Log::info('Product rejected', ['product_id' => $product->id, 'status' => $product->status]);

        // Notify user with rejection reason
    if ($request->has('reason')) {
        $product->user->notify(new ListingRejected($product, $request->reason));
    } else {
        return redirect()->back()->with('error', 'Rejection reason not provided.');
    }

        return redirect()->route('listing_management')->with('success', 'Listing rejected.');    
    }

    public function edit(NewProduct $listing)
    {
        return view('products.edit', compact('listing'));
    }

    public function update(Request $request, NewProduct $listing)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($listing->image) {
                Storage::delete('public/' . $listing->image);
            }

            // Store the new image
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $listing->update($data);

        return redirect()->route('listing_management')->with('success', 'Listing updated successfully.');
    }

    // Method to delete the listing
    public function destroy(NewProduct $listing)
    {
        // Delete image if exists
        if ($listing->image) {
            Storage::delete('public/' . $listing->image);
        }

        $listing->delete();

        return redirect()->route('listing_management')->with('success', 'Listing deleted successfully.');
    }
}

