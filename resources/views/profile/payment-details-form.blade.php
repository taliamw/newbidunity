<!-- resources/views/profile/payment-details-form.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Details') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('payment-details.update') }}">
                @csrf
                @method('PUT')

                <!-- Card Brand -->
                <div>
                    <x-label for="card_brand" value="{{ __('Card Brand') }}" />
                    <x-input id="card_brand" type="text" class="mt-1 block w-full" name="card_brand" :value="old('card_brand', auth()->user()->card_brand)" required />
                </div>

                <!-- Card Last 4 Digits -->
                <div class="mt-4">
                    <x-label for="card_last4" value="{{ __('Card Last 4 Digits') }}" />
                    <x-input id="card_last4" type="text" class="mt-1 block w-full" name="card_last4" :value="old('card_last4', auth()->user()->card_last4)" required />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
