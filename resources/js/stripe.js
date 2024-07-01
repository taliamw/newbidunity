// Initialize Stripe.js with your publishable key
const stripe = Stripe('pk_test_51PXSMPJnfltRCm4T1k9QWl0jrflEBgzkpVTjjU1FUTQZkKx6mn25sqIIZb5tKz6hyjrFlFQ9sJRogmVNiPCe5DtD00NNq8K2aF');

// Create an instance of Stripe elements
const elements = stripe.elements();

// Create and mount the card element
const cardElement = elements.create('card');
cardElement.mount('#card-element');

// Handle form submission
const handleSubmit = async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    const { setupIntent, error } = await stripe.confirmCardSetup(
        formData.get('setup_intent_client_secret'), // This should come from your server
        {
            payment_method: {
                card: cardElement,
                billing_details: {
                    name: formData.get('name'),
                    // Add additional billing details if needed
                },
            },
        }
    );

    if (error) {
        console.error('Failed to confirm card setup:', error);
        // Handle error display or retry logic
        const errorElement = document.getElementById('card-errors');
        errorElement.textContent = error.message;
    } else {
        console.log('SetupIntent successful:', setupIntent);

        // Send the SetupIntent client secret to your Laravel server
        const response = await fetch('/handle-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                setup_intent_client_secret: setupIntent.client_secret,
                // Add additional data if needed
            }),
        });

        // Handle server response (success or error)
        const responseData = await response.json();
        if (response.ok) {
            console.log('Payment confirmed on server:', responseData);
            alert('Payment successful!');
            // Optionally handle success UI or redirect to success page
        } else {
            console.error('Failed to confirm payment on server:', responseData.error);
            // Handle error display or retry logic
        }
    }
};

// Attach event listener to payment form submission
const form = document.getElementById('payment-form');
form.addEventListener('submit', handleSubmit);
