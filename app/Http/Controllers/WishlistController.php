<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewProduct;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function add(NewProduct $product)
    {
        $user = Auth::user();
        $user->wishlist()->attach($product->id);

        return redirect()->back()->with('success', 'Product added to wishlist.');
    }

    public function remove(NewProduct $product)
    {
        $user = Auth::user();
        $user->wishlist()->detach($product->id);

        return redirect()->back()->with('success', 'Product removed from wishlist.');
    }
}
