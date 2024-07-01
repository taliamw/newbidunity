<!-- resources/views/wishlist/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Your Wishlist</h1>

    <div class="row">
        @forelse($wishlist as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($item->image)
                <img class="card-img-top" src="data:image/jpeg;base64,{{ $item->image }}" alt="{{ $item->name }}">
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <span>No Image Available</span>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description }}</p>
                    <h5 class="card-text">${{ $item->price }}</h5>
                </div>
                <div class="card-footer">
                    <form action="{{ route('wishlist.remove', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block">Remove</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                Your wishlist is empty.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
