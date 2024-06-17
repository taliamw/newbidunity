<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PaymentDetailsController extends Controller
{
    /**
     * Show the form for editing the user's payment details.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.payment-details-form');
    }

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
        ]);

        $user = auth()->user();
        $user->update([
            'card_brand' => $request->card_brand,
            'card_last4' => $request->card_last4,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Payment details updated successfully.');
    }
}
