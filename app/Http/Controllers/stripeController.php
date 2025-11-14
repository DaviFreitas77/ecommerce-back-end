<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class stripeController extends Controller
{
    public function createPayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'integer']
        ]);

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 1000, 
        'currency' => 'brl',
        'automatic_payment_methods' => [
            'enabled' => true,
        ],
        'statement_descriptor' => 'Bazar',
    ]);

    return response()->json([
        'clientSecret' => $paymentIntent->client_secret,
    ]);
    }
}
