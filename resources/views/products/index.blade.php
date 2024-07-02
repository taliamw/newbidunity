@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Products</h1>

    <!-- Search bar -->
    <div class="flex mb-4">
        <form action="{{ route('products.index') }}" method="GET" class="flex w-full">
            <input type="text" name="search" class="form-input w-full" placeholder="Search products" value="{{ request()->input('search') }}">
            <button type="submit" class="btn btn-primary ml-2">Search</button>
        </form>
    </div>

    <!-- Product cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($products as $product)
        <div class="card border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
            @if($product->image)
                <img class="w-full h-48 object-cover rounded-t-lg" src="{{ $product->image }}" alt="{{ $product->name }}">
            @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                    <span>No Image Available</span>
                </div>
            @endif
            <div class="p-4">
                <h4 class="text-lg font-semibold">{{ $product->name }}</h4>
                <p class="text-gray-600">{{ $product->description }}</p>
                <h5 class="text-xl font-bold mt-2">${{ $product->price }}</h5>
            </div>
            <div class="p-4 bg-gray-100 flex justify-between items-center">
                <form action="{{ route('wishlist.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        @if(auth()->user()->wishlist && auth()->user()->wishlist->contains($product->id))
                            Remove from Wishlist
                        @else
                            Add to Wishlist
                        @endif
                    </button>
                </form>
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">View Details</a>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-2 lg:col-span-3">
            <div class="alert alert-warning" role="alert">
                No products available.
            </div>
            <!-- Placeholder products -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @for($i = 1; $i <= 3; $i++)
                <div class="card border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                        <span>No Image Available</span>
                    </div>
                    <div class="p-4">
                        <h4 class="text-lg font-semibold">Placeholder Product {{ $i }}</h4>
                        <p class="text-gray-600">This is a description of placeholder product {{ $i }}.</p>
                        <h5 class="text-xl font-bold mt-2">$99.99</h5>
                    </div>
                    <div class="p-4 bg-gray-100">
                        <a href="#" class="btn btn-primary w-full">View Details</a>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        @endforelse
    </div>

    <!-- Navigation -->
    <div class="mt-6">
        {{ $products->appends(request()->input())->links() }}
    </div>
</div>
@endsection
