@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">{{ $product->name }}</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
        @if($product->image)
    <img src="{{ $product->image }}" class="card-img-top" alt="">
@else
    <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
        <span>No Image Available</span>
    </div>
@endif
        </div>
        <div class="col-md-6">
            <h3 class="my-3">Ksh{{ number_format($product->price, 2) }}</h3>
            <p>{{ $product->description }}</p>

            {{-- Display Remaining Time --}}
            <h4 class="my-3">Auction Ends In: <span id="countdown-{{ $product->id }}" class="badge badge-info"></span></h4>

            {{-- Determine Auction Status --}}
            <h4 class="my-3">Auction Status:
                @if($highestBid)
                    <span class="badge badge-info">Highest Bid: Ksh{{ number_format($highestBid->amount, 2) }}</span>
                @else
                    <span class="badge badge-secondary">No Bids Yet</span>
                @endif
            </h4>

            {{-- Wishlist Form --}}
            @auth
                @if(auth()->user()->wishlist && auth()->user()->wishlist->contains($product->id))
                <form action="{{ route('wishlist.remove', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="background-color: #007bff; border-color: #007bff;">Remove from Wishlist</button>
                </form>
                @else
                <form action="{{ route('wishlist.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Add to Wishlist</button>
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
                <div class="form-group">
                    <label for="bid_type">Bid Type:</label>
                    <select name="bid_type" class="form-control" id="bid_type" required>
                        <option value="team">Team</option>
                        <option value="individual">Individual  ------------(must be in current team with only you as member)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Place Bid</button>
            </form>
            @else
            <div class="alert alert-warning mt-3">Auction has ended. No more bids can be placed.</div>
            @endif

            {{-- Display Success Message --}}
@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif


            {{-- Display Error Message --}}
            @if(session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif



            {{-- Display User Bids --}}
<h4 class="my-3">Bids</h4>
<ul class="list-group">
    @foreach($userBids as $bid)
        @php
            $user = $users->firstWhere('id', $bid->user_id);
            $team = $teams->firstWhere('id', $bid->team_id);
        @endphp
        @if($user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    {{ $user->name }}
                    @if($team)
                        ({{ $team->name }})
                    @endif
                </span>
                <span>Ksh{{ number_format($bid->total_amount, 2) }}</span>
                @auth
                    @if(auth()->user()->id === $user->id)
                        <a href="{{ route('products.bids_show', ['user' => $user->id]) }}" class="btn btn-sm btn-primary">View Bids</a>
                    @endif
                @endauth
            </li>
        @endif
    @endforeach
</ul>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const endTime = new Date("{{ $remainingTime }}").getTime();
    const countdownElement = document.getElementById('countdown-{{ $product->id }}');

    const updateCountdown = () => {
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance <= 0) {
            countdownElement.innerHTML = "Auction Ended";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
    };

    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>

@endsection
