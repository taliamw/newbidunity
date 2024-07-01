<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set your Stripe secret key here
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Show the payment form.
     *
     * @return \Illuminate\View\View
     */
    public function showPaymentForm()
    {
        $intent = PaymentIntent::create([
            'amount' => 1099, // Amount in cents
            'currency' => 'usd',
        ]);

        return view('payment', [
            'clientSecret' => $intent->client_secret,
        ]);
    }

    /**
     * Handle the payment form submission.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handlePayment(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
        ]);

        try {
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);
            $paymentIntent->confirm([
                'payment_method' => $request->payment_method_id,
            ]);

            return response()->json(['success' => true]);
        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
