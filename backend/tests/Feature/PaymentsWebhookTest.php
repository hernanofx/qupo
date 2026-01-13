<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Merchant;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentsWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_webhook_confirms_booking_and_creates_payment()
    {
        $owner = User::factory()->create(['role' => 'merchant']);
        $merchant = Merchant::create(['owner_id' => $owner->id, 'name' => 'M', 'slug' => 'm']);
        $service = Service::create(['merchant_id' => $merchant->id, 'title' => 'S', 'duration_min' => 30, 'price_cents' => 1000]);
        $user = User::factory()->create();

        $booking = Booking::create(['user_id' => $user->id, 'merchant_id' => $merchant->id, 'service_id' => $service->id, 'starts_at' => now()->addDay(), 'ends_at' => now()->addDay()->addMinutes(30), 'status' => 'pending', 'price_cents' => 1000]);

        $payload = [
            'type' => 'checkout.session.completed',
            'data' => ['object' => [
                'id' => 'cs_test_123',
                'metadata' => ['booking_id' => (string)$booking->id],
                'amount_total' => 1000,
                'currency' => 'usd',
            ]]
        ];

        $this->postJson('/api/v1/payments/webhook', $payload)->assertStatus(200);

        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'status' => 'confirmed']);
        $this->assertDatabaseHas('payments', ['booking_id' => $booking->id, 'status' => 'succeeded']);
    }
}
