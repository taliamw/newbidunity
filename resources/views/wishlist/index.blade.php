@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Your Wishlist</h1>

    <div class="row">
        @forelse($wishlist as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="">
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <span>No Image Available</span>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description }}</p>
                    <h5 class="card-text">${{ number_format($item->price, 2) }}</h5>

                    {{-- Display Remaining Time and Auction Status --}}
                    @php
                        $isAuctionActive = $item->isAuctionActive();
                    @endphp
                    <h6 class="card-text">Auction Ends In: <span id="countdown-{{ $item->id }}" class="badge badge-info"></span></h6>
                    <h6 class="card-text">Auction Status: 
                        @if($isAuctionActive)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Ended</span>
                        @endif
                    </h6>
                </div>
                <div class="card-footer">
                    <form action="{{ route('wishlist.remove', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block" style="background-color: #dc3545; border-color: #dc3545;">Remove</button>
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

{{-- Include Countdown Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($wishlist as $item)
        var endTime{{ $item->id }} = new Date('{{ $item->getEndTime() }}').getTime();
        var countdownElement{{ $item->id }} = document.getElementById('countdown-{{ $item->id }}');

        function updateCountdown{{ $item->id }}() {
            var now = new Date().getTime();
            var distance = endTime{{ $item->id }} - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement{{ $item->id }}.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(countdownInterval{{ $item->id }});
                countdownElement{{ $item->id }}.innerHTML = "EXPIRED";
            }
        }

        var countdownInterval{{ $item->id }} = setInterval(updateCountdown{{ $item->id }}, 1000);
        @endforeach
    });
</script>
@endsection
