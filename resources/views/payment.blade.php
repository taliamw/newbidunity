<!-- payment.form.blade.php -->
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form id="payment-form" action="{{ route('payment.handle') }}" method="POST">
            @csrf
            <input type="hidden" id="client_secret" name="client_secret" value="{{ $clientSecret }}">
            <div>
                <x-label for="name" value="{{ __('Name on Card') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="amount" value="{{ __('Amount') }}" />
                <p id="amount" class="block mt-1 w-full bg-gray-100 p-2 rounded">Ksh {{ $amount }}</p>
            </div>

            <div class="mt-4">
                <x-label for="card-element" value="{{ __('Credit or Debit Card') }}" /><br>
                <div id="card-element" class="block mt-1 w-full"></div>
                <div id="card-errors" class="mt-2 text-sm text-red-600"></div><br>
            </div>

            <div>
                <x-button id="submit">
                    {{ __('Submit Payment') }}
                </x-button>
            </div>
        </form>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('dashboard') }}" class="ml-4 text-sm text-gray-600 underline">Back to Dashboard</a>
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

                const { paymentIntent, error } = await stripe.confirmCardPayment(
                    document.getElementById('client_secret').value,
                    {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: document.getElementById('name').value
                            }
                        }
                    }
                );

                if (error) {
                    console.error('Failed to confirm card payment:', error);
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                } else {
                    console.log('Payment confirmed successfully:', paymentIntent);
                    alert('Payment successful!');
                    window.location.href = `/allocation/report/1`;
                }
            };

            const form = document.getElementById('payment-form');
            form.addEventListener('submit', handleSubmit);
        });
    </script>
</x-guest-layout>
