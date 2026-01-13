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

        $sessionData = [
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
        ];

        if (!empty($data['booking_id'])) {
            $sessionData['metadata'] = ['booking_id' => $data['booking_id']];
        }

        $session = CheckoutSession::create($sessionData);

        return response()->json(['id' => $session->id]);
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            if ($endpointSecret) {
                $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
            } else {
                // In tests or if not configured, decode directly
                $event = json_decode($payload, true);
            }
        } catch (\UnexpectedValueException $e) {
            return response()->json(['message' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $type = is_array($event) ? $event['type'] ?? null : $event->type;
        $data = is_array($event) ? $event['data']['object'] ?? [] : $event->data->object;

        if ($type === 'checkout.session.completed' || $type === 'payment_intent.succeeded') {
            $bookingId = $data['metadata']['booking_id'] ?? null;
            $amount = intval(($data['amount_total'] ?? $data['amount']) ?? 0);
            if ($bookingId) {
                $booking = \App\Models\Booking::find($bookingId);
                if ($booking) {
                    $booking->status = 'confirmed';
                    $booking->save();

                    \App\Models\Payment::create([
                        'booking_id' => $booking->id,
                        'amount_cents' => $amount,
                        'currency' => strtoupper($data['currency'] ?? 'USD'),
                        'provider' => 'stripe',
                        'provider_id' => $data['id'] ?? null,
                        'status' => 'succeeded',
                    ]);
                }
            }
        }

        return response()->json(['received' => true]);
    }
}
