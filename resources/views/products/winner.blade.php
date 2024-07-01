<!-- resources/views/products/winner.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">{{ $product->name }}</h1>

    <div class="my-4">
        @if($highestBid)
            <h2 class="text-xl font-bold mb-2">Winning Bid</h2>
            <p>{{ $highestBid->user->name }}: ${{ $highestBid->amount }}</p>
        @else
            <p>No bids placed yet.</p>
        @endif
    </div>
</div>
@endsection
