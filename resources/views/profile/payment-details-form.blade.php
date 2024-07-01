<x-app-layout>
    <x-authentication-card>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Payment Details') }}
        </h2>
    </x-slot>
    <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-validation-errors class="mb-4" />

                <form id="payment-method-form" method="POST" action="{{ route('payment-details.update') }}">
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
                </div><br><br>
                <div class="border-t border-gray-200"></div>
<br>
                <x-label for="card_brand" value="{{ __('Card Details') }}" />
<br>
                <div id="card-element"></div><br>
                <div class="border-t border-gray-200"></div>

                <x-button class="mt-4">
                        {{ __('Save Payment Method') }}
                    </x-button>
                </form><br>
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-500">Powered by Stripe</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stripe = Stripe('{{ env('STRIPE_KEY') }}');
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');

            const form = document.getElementById('payment-method-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    '{{ $clientSecret }}', {
                        payment_method: {
                            card: cardElement,
                            billing_details: { name: '{{ auth()->user()->name }}' }
                        }
                    }
                );

                if (error) {
                    console.error('Error:', error);
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'payment_method_id');
                    hiddenInput.setAttribute('value', setupIntent.payment_method);
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            });
        });
    </script>
    </x-authentication-card>
</x-app-layout>
