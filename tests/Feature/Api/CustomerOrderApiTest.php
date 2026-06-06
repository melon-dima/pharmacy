<?php

namespace Tests\Feature\Api;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventoryItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerOrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_mobile_user_can_create_pickup_order(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['mobile']);
        $pharmacy = Pharmacy::query()->create([
            'name' => 'Central Pharmacy',
            'is_active' => true,
        ]);
        $medicine = Medicine::query()->create([
            'name' => 'Aspirin',
            'sku' => 'MED-001',
            'is_active' => true,
        ]);
        PharmacyInventoryItem::query()->create([
            'pharmacy_id' => $pharmacy->id,
            'medicine_id' => $medicine->id,
            'quantity' => 12,
            'minimum_quantity' => 2,
        ]);

        $response = $this->postJson('/api/v1/orders', [
            'delivery_type' => 'pickup',
            'pharmacy_id' => $pharmacy->id,
            'customer_name' => 'Alice',
            'customer_phone' => '+100000000',
            'items' => [
                ['medicine_id' => $medicine->id, 'quantity' => 2],
            ],
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('data.delivery_type', 'pickup')
            ->assertJsonPath('data.status', 'pending')
            ->assertJsonPath('data.items.0.medicine_name', 'Aspirin');
        $this->assertDatabaseHas('customer_orders', [
            'user_id' => $user->id,
            'pharmacy_id' => $pharmacy->id,
            'delivery_type' => 'pickup',
        ]);
    }

    public function test_guest_cannot_create_order(): void
    {
        $response = $this->postJson('/api/v1/orders', []);

        $response->assertUnauthorized();
    }
}
