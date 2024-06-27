<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4">
            <h1 class="text-2xl font-bold">{{ $team->name }}</h1>
            <p class="text-gray-600 mt-2">Created: {{ $team->created_at->diffForHumans() }}</p>
            <!-- You can add more details here -->
            <div class="mt-4">
                <h3 class="text-lg font-semibold">Owner</h3>
                <p>{{ $team->owner->name }}</p>
            </div>
            <div class="mt-4">
                <h3 class="text-lg font-semibold">Members</h3>
                <ul>
                    @foreach ($team->users as $user)
                        <li>{{ $user->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('dashboard') }}" class="ml-4 text-sm text-gray-600 underline">Back to Dashboard</a>
        </div>
    </x-authentication-card>
</x-guest-layout>
