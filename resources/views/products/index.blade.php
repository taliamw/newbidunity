@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Products</h1>

    <!-- Search bar -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="{{ route('products.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search products">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-secondary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Product cards -->
    <div class="row">
        @forelse($products as $product)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                @if($product->image)
                    <img class="card-img-top" src="{{ $product->image }}" alt="{{ $product->name }}">
                @else
                    <div class="image-placeholder" style="height: 200px; background-color: #eee; text-align: center; display: flex; justify-content: center; align-items: center;">
                        <span>No Image Available</span>
                    </div>
                @endif
                <div class="card-body">
                    <h4 class="card-title">{{ $product->name }}</h4>
                    <p class="card-text">{{ $product->description }}</p>
                    <h5>${{ $product->price }}</h5>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                No products available.
            </div>
            <!-- Placeholder products -->
            <div class="row">
                @for($i = 1; $i <= 3; $i++)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="image-placeholder" style="height: 200px; background-color: #eee; text-align: center; display: flex; justify-content: center; align-items: center;">
                            <span>No Image Available</span>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Placeholder Product {{ $i }}</h4>
                            <p class="card-text">This is a description of placeholder product {{ $i }}.</p>
                            <h5>$99.99</h5>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        @endforelse
    </div>

    <!-- Navigation -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>
</div>
@endsection
