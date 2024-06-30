@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ $product->name }}</h1>
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img class="img-fluid" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
            @else
                <div class="image-placeholder" style="height: 200px; background-color: #eee; text-align: center; display: flex; justify-content: center; align-items: center;">
                    <span>No Image Available</span>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h4>Description</h4>
            <p>{{ $product->description }}</p>
            <h5>Price: ${{ $product->price }}</h5>
            <p><strong>Auction Status:</strong> {{ ucfirst($product->auction_status) }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
        </div>
    </div>
</div>
@endsection
