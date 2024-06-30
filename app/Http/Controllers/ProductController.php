<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewProduct;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = NewProduct::where('name', 'like', "%{$search}%")->paginate(12);
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = NewProduct::findOrFail($id);
        return view('products.show', compact('product'));
    }
}
