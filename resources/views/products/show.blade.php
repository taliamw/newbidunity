@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">{{ $product->name }}</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="">
            @else
            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                <span>No Image Available</span>
            </div>
            @endif
        </div>
        <div class="col-md-6">
            <h3 class="my-3">${{ number_format($product->price, 2) }}</h3>
            <p>{{ $product->description }}</p>

            {{-- Display Remaining Time --}}
            <h4 class="my-3">Auction Ends In: <span id="countdown-{{ $product->id }}" class="badge badge-info"></span></h4>

            {{-- Determine Auction Status --}}
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
            @if($isAuctionActive)
            <form action="{{ route('products.placeBid', $product) }}" method="POST" class="mt-3">
                @csrf
                <div class="form-group">
                    <label for="amount">Place your bid:</label>
                    <input type="number" name="amount" class="form-control" id="amount" step="0.01" min="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Place Bid</button>
            </form>
            @else
            <div class="alert alert-warning mt-3">Auction has ended. No more bids can be placed.</div>
            @endif

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
            @if(!$isAuctionActive && $highestBid)
            <div class="mt-4">
                <h4>Winning Bid</h4>
                <p>{{ $highestBid->user->name }} - ${{ number_format($highestBid->amount, 2) }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Include Countdown Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var endTime = new Date('{{ $product->getEndTime() }}').getTime();
        var countdownElement = document.getElementById('countdown-{{ $product->id }}');

        function updateCountdown() {
            var now = new Date().getTime();
            var distance = endTime - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(countdownInterval);
                countdownElement.innerHTML = "EXPIRED";
            }
        }

        var countdownInterval = setInterval(updateCountdown, 1000);
    });
</script>
@endsection
