<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MerchantAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_merchant_can_register()
    {
        $payload = [
            'name' => 'Owner Name',
            'email' => 'owner@example.com',
            'password' => 'secret1234',
            'merchant_name' => 'Mi Salon',
        ];

        $response = $this->postJson('/api/v1/merchant/register', $payload);
        $response->assertStatus(201);
        $response->assertJsonStructure(['user', 'merchant', 'token']);

        $this->assertDatabaseHas('users', ['email' => 'owner@example.com', 'role' => 'merchant']);
        $this->assertDatabaseHas('merchants', ['name' => 'Mi Salon']);
    }

    public function test_merchant_can_login()
    {
        $user = User::factory()->create(['email' => 'login@example.com', 'password' => 'password', 'role' => 'merchant']);

        $response = $this->postJson('/api/v1/merchant/login', ['email' => 'login@example.com', 'password' => 'password']);
        $response->assertStatus(200);
        $response->assertJsonStructure(['user', 'token']);
    }
}
