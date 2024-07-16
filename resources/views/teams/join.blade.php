<x-guest-layout>
    <x-authentication-card>

        <div class="mb-4">
            <h1 class="text-2xl font-bold">Join a Team</h1>
        </div>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('teams.sendJoinRequest') }}">
            @csrf

            <div>
                <x-label for="team_name" value="Team Name" />
                <x-input id="team_name" class="block mt-1 w-full" type="text" name="team_name" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Send request to team owner') }}
                </x-button>
            </div>
        </form>
<br><br><br>
        <div class="pt-4 pb-1 border-t border-gray-200">

        <div class="mb-4">
            <h1 class="text-2xl font-bold">Create a Team</h1>
        </div>
        <x-slot name="logo">
            <x-custom-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form id="create-team-form" method="POST" action="{{ route('teams.store') }}">
            @csrf

            <div>
                <x-label for="team_name" value="{{ __('Enter team name') }}" />
                <x-input id="team_name" class="block mt-1 w-full" type="text" placeholder="eg. Chings" name="name" :value="old('name')" required autofocus autocomplete="team_name" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Create Team') }}
                </x-button>
            </div>

            <div class="flex items-center justify-end mt-4">
            <a href="{{ route('dashboard') }}" class="ml-4 text-sm text-gray-600 underline">Back to Dashboard</a>
        </div>

        </form>
    </x-authentication-card>
</x-guest-layout>
