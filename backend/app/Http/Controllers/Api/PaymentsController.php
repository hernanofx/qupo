<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class PaymentsController extends Controller
{
    public function checkout(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3',
            'success_url' => 'required|url',
            'cancel_url' => 'required|url',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($data['currency']),
                    'product_data' => ['name' => 'QUPO Checkout'],
                    'unit_amount' => intval($data['amount'] * 100),
                ],
                'quantity' => 1,
            ]],
            'success_url' => $data['success_url'],
            'cancel_url' => $data['cancel_url'],
        ]);

        return response()->json(['id' => $session->id]);
    }
}
