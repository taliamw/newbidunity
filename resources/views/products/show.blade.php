@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">{{ $product->name }}</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            @if($product->image)
            <img src="{{ URL('images\products\company.jpg') }}" class="card-img-top" alt="">
            @else
            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                <span>  <img src="{{ URL('images\products\company.jpg') }}" class="card-img-top" alt="">
</span>
            </div>
            @endif
        </div>
        <div class="col-md-6">
            <h3 class="my-3">${{ number_format($product->price, 2) }}</h3>
            <p>{{ $product->description }}</p>

            {{-- Determine Auction Status --}}
            @php
                $highestBid = $product->bids()->orderBy('amount', 'desc')->first();
            @endphp
            <h4 class="my-3">Auction Status:
                @if($highestBid)
                    <span class="badge badge-info">Highest Bid: ${{ number_format($highestBid->amount, 2) }}</span>
                @else
                    <span class="badge badge-secondary">No Bids Yet</span>
                @endif
            </h4>

            {{-- Wishlist Form --}}
            @auth
                @if(auth()->user()->wishlist && auth()->user()->wishlist->contains($product->id))
                <form action="{{ route('wishlist.remove', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Remove from Wishlist</button>
                </form>
                @else
                <form action="{{ route('wishlist.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Add to Wishlist</button>
                </form>
                @endif
            @else
                <button type="button" class="btn btn-primary" onclick="alert('Please log in to add to wishlist')">Add to Wishlist</button>
            @endauth

            {{-- Bid Form --}}
            <form action="{{ route('products.placeBid', $product) }}" method="POST" class="mt-3">
                @csrf
                <div class="form-group">
                    <label for="amount">Place your bid:</label>
                    <input type="number" name="amount" class="form-control" id="amount" step="0.01" min="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Place Bid</button>
            </form>

            {{-- Bids List --}}
            <h4 class="my-3">Bids</h4>
            <ul class="list-group">
                @foreach($bids as $bid)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $bid->user->name }}</span>
                    <span>${{ number_format($bid->amount, 2) }}</span>
                    @auth
                        @if(auth()->user()->id === $bid->user_id)
                        <form action="{{ route('products.removeBid', $bid) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Remove Bid</button>
                        </form>
                        @endif
                    @endauth
                </li>
                @endforeach
            </ul>

            {{-- Winning Bid --}}
            @if($winningBid)
            <div class="mt-4">
                <h4>Winning Bid</h4>
                <p>{{ $winningBid->user->name }} - ${{ number_format($winningBid->amount, 2) }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
