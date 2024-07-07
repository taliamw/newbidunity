<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use App\Models\Payment;

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
    public function showPaymentForm(Request $request)
    {
        $amount = intval($request->input('amount') * 100);

        try {
            // Create a PaymentIntent for immediate payment
            $intent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'payment_method_types' => ['card'],
            ]);

            return view('payment', [
                'clientSecret' => $intent->client_secret,
                'amount' => $request->input('amount'),
            ]);
        } catch (ApiErrorException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }       
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
            'name' => 'required|string',
            'setup_intent_client_secret' => 'required|string',
        ]);

        try {
            // Retrieve the PaymentIntent using client secret
            $paymentIntent = PaymentIntent::retrieve($request->setup_intent_client_secret);

            // Confirm the PaymentIntent with the payment method
            $paymentIntent->confirm([
                'payment_method' => $request->payment_method_id,
            ]);

            // Save the payment details in the database
            $payment = new Payment();
            $payment->user_id = auth()->id(); // Assuming user is authenticated
            $payment->amount = $paymentIntent->amount / 100; // Convert back to dollars
            $payment->stripe_payment_intent_id = $paymentIntent->id;
            $payment->status = $paymentIntent->status;

            $payment->save();

            return redirect()->route('allocation.report.pdf',);
            
        } catch (ApiErrorException $e) {
            Log::error('Error confirming PaymentIntent: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to confirm payment.'], 500);
        } catch (\Exception $e) {
            Log::error('Error saving payment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save payment.'], 500);
        }
    }
}

