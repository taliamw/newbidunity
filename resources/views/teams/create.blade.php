<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form id="create-team-form" method="POST" action="{{ route('teams.store') }}">
            @csrf

            <div>
                <x-label for="team_name" value="{{ __('Team Name') }}" />
                <x-input id="team_name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="team_name" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Create Team') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
