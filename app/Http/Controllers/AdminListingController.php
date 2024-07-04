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
        return redirect()->route('listing_management')->with('success', 'Listing rejected.');    }
}
