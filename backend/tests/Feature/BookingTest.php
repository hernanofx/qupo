<?php

namespace Tests\Feature;

use App\Models\Merchant;
use App\Models\Service;
use App\Models\User;
use App\Models\Availability;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_booking_if_slot_free()
    {
        $owner = User::factory()->create(['role' => 'merchant']);
        $merchant = Merchant::create(['owner_id' => $owner->id, 'name' => 'M', 'slug' => 'm']);
        $service = Service::create(['merchant_id' => $merchant->id, 'title' => 'S', 'duration_min' => 30, 'price_cents' => 1000]);

        $user = User::factory()->create();

        $starts = now()->addDays(1)->format('Y-m-d H:i:s');

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/bookings', ['service_id' => $service->id, 'starts_at' => $starts])
            ->assertStatus(201)
            ->assertJsonPath('service_id', $service->id);
    }
}
