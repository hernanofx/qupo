<?php

namespace Tests\Feature;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MerchantPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_owner_cannot_update_merchant()
    {
        $owner = User::factory()->create(['role' => 'merchant']);
        $other = User::factory()->create();

        $merchant = Merchant::create(['owner_id' => $owner->id, 'name' => 'M', 'slug' => 'm']);

        $this->actingAs($other, 'sanctum')
            ->putJson('/api/v1/merchants/'.$merchant->id, ['name' => 'X'])
            ->assertStatus(403);
    }

    public function test_owner_can_update_merchant()
    {
        $owner = User::factory()->create(['role' => 'merchant']);
        $merchant = Merchant::create(['owner_id' => $owner->id, 'name' => 'M', 'slug' => 'm']);

        $this->actingAs($owner, 'sanctum')
            ->putJson('/api/v1/merchants/'.$merchant->id, ['name' => 'New Name'])
            ->assertStatus(200)
            ->assertJsonPath('name', 'New Name');
    }
}
