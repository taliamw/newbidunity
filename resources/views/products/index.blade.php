@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Products</h1>

    <!-- Create Product Button -->
    @auth
    <div class="flex justify-end mb-4">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createProductModal">Add Product</button>
        <a href="{{ route('wishlist.index') }}" class="btn btn-primary ms-2">My Wishlist</a> <!-- Link to go to the wishlist page -->

    </div>
    @endauth

    <!-- Search bar -->
    <div class="flex mb-4">
        <form action="{{ route('products.index') }}" method="GET" class="flex w-full">
            <input type="text" name="search" class="form-input w-full" placeholder="Search products" value="{{ request()->input('search') }}">
            <button type="submit" class="btn btn-primary ml-2" style="background-color: #007bff; border-color: #007bff;">Search</button>
        </form>
    </div>

    <!-- Product cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($products as $product)
        <div class="card border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
       
        @if($product->image)
    <img src="{{ $product->image }}" class="card-img-top" alt="">
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
                @auth
                <form action="{{ route('wishlist.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">
                        @if(auth()->user()->wishlist && auth()->user()->wishlist->contains($product->id))
                            Remove from Wishlist
                        @else
                            Add to Wishlist
                        @endif
                    </button>
                </form>
                @endauth
                @guest
                <button type="button" class="btn btn-primary" onclick="alert('Please log in to add to wishlist')">Add to Wishlist</button>
                @endguest
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
        {{ $products->links() }}
    </div>
</div>

<!-- Create Product Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" id="price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file" id="image" required>
        </div>
        <div class="form-group">
    <label for="duration">Duration (in Days)</label>
    <input type="number" name="duration" class="form-control" id="duration" min="1" required>
</div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: #6c757d; border-color: #6c757d;">Close</button>
        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Add Product</button>
    </div>
</form>

        </div>
    </div>
</div>
@endsection
