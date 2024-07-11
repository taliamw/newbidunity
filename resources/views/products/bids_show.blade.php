<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4">
            <h1 class="text-2xl font-bold">{{ $user->name }}'s Bids</h1>

            <div class="mt-4">
                <h3 class="text-lg font-semibold">Bids</h3>
                <ul>
                    @foreach ($userBids as $bid)
                        <li class="border border-gray-200 rounded-md p-4 mb-2">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-semibold">{{ $bid->product->name }}</h4>
                                    <p class="text-gray-600">Bid Amount: Ksh{{ number_format($bid->amount, 2) }}</p>
                                    <p class="text-gray-600">Placed At: {{ $bid->created_at->diffForHumans() }}</p>
                                </div>
                                @auth
                                    @if(auth()->user()->id === $user->id)
                                        <form action="{{ route('products.removeBid', ['bid' => $bid->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" style="background-color: #dc3545; border-color: #dc3545;" onclick ="return confirm('Are you sure you want to permanently delete this bid?')">Remove Bid</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('products.index') }}" class="ml-4 text-sm text-gray-600 underline">Back to Products</a>
        </div>
    </x-authentication-card>
</x-guest-layout>
