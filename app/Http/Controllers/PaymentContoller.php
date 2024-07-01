<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Stripe\Stripe;
use Stripe\SetupIntent;

use Stripe\Customer;
use Stripe\PaymentMethod as StripePaymentMethod;

class PaymentDetailsController extends Controller
{
    /**
     * Show the form for editing the user's payment details.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = auth()->user();

        Stripe::setApiKey(env('STRIPE_SECRET'));

        if (!$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $user->email,
            ]);
            $user->stripe_customer_id = $customer->id;
            $user->save();
        }

        $setupIntent = SetupIntent::create([
            'customer' => $user->stripe_customer_id,
        ]);

        return view('profile.payment-details-form', [
            'clientSecret' => $setupIntent->client_secret,
        ]);    }

    /**
     * Update the user's payment details.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'card_brand' => ['required', 'string', 'max:255'],
            'card_last4' => ['required', 'digits:4'],
            'payment_method_id' => ['required', 'string'],
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = auth()->user();

        if (!$user->stripe_customer_id) {
            $customer = Customer::create([
                'email' => $user->email,
            ]);
            $user->stripe_customer_id = $customer->id;
        } else {
            $customer = Customer::retrieve($user->stripe_customer_id);
        }

        $paymentMethod = StripePaymentMethod::retrieve($request->payment_method_id);
        $paymentMethod->attach(['customer' => $customer->id]);


        $user->update([
            'stripe_payment_method_id' => $paymentMethod->id,
            'card_brand' => $request->card_brand,
            'card_last4' => $request->card_last4,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Payment details updated successfully.');
    }
}
