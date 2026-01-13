<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;

class MerchantVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_sends_verification_email()
    {
        Notification::fake();

        $payload = [
            'name' => 'Owner Name',
            'email' => 'owner2@example.com',
            'password' => 'secret1234',
            'merchant_name' => 'Mi Salon 2',
        ];

        $response = $this->postJson('/api/v1/merchant/register', $payload);
        $response->assertStatus(201);

        $user = User::where('email', 'owner2@example.com')->first();
        $this->assertNotNull($user);

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
