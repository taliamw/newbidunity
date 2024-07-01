<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form id="payment-form" method="POST" action="{{ route('payment.handle') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name on Card') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="card-element" value="{{ __('Credit or Debit Card') }}" /><br>
                <div id="card-element" class="block mt-1 w-full"></div>
                <div id="card-errors" class="mt-2 text-sm text-red-600"></div><br>
            </div>

            <input type="hidden" name="setup_intent_client_secret" value="{{ $clientSecret }}" />
<br>

            <div>
                <x-button id="submit" class="ml-4">
                    {{ __('Submit Payment') }}
                </x-button>
            </div>
        </form>
        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('dashboard') }}" class="ml-4 text-sm text-gray-600 underline">Back to Dashboard</a>
        </div>
        <br>
        <div class="border-t border-gray-200"></div>
        <div class="mt-4 text-center">
                    <p class="text-sm text-gray-500">Powered by Stripe</p>
                </div>
    </x-authentication-card>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stripe = Stripe('{{ env('STRIPE_KEY') }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');

            const handleSubmit = async (event) => {
                event.preventDefault();

                const formData = new FormData(event.target);

                const { setupIntent, error } = await stripe.confirmCardSetup(
                    formData.get('setup_intent_client_secret'), 
                    {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: formData.get('name'),
                            },
                        },
                    }
                );

                if (error) {
                    console.error('Failed to confirm card setup:', error);
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                } else {
                    console.log('SetupIntent successful:', setupIntent);

                    const response = await fetch('/handle-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            setup_intent_client_secret: setupIntent.client_secret,
                        }),
                    });

                    const responseData = await response.json();
                    if (response.ok) {
                        console.log('Payment confirmed on server:', responseData);
                        alert('success')
                        redirect
                    } else {
                        console.error('Failed to confirm payment on server:', responseData.error);
                        alert('Failed to confirm payment.')
                    }
                }
            };

            const form = document.getElementById('payment-form');
            form.addEventListener('submit', handleSubmit);
        });
    </script>
</x-guest-layout>
