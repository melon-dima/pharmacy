<?php

namespace Tests\Feature\Modules\Inventory;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventoryItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_inventory_item_with_normalized_sku(): void
    {
        $user = User::factory()->create();
        $pharmacy = Pharmacy::query()->create([
            'name' => 'Central Pharmacy',
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('inventory.store'), [
                'pharmacy_id' => $pharmacy->id,
                'medicine_name' => 'Aspirin',
                'medicine_sku' => ' med-001 ',
                'manufacturer' => 'Acme',
                'unit' => 'pack',
                'quantity' => 15,
                'minimum_quantity' => 4,
                'expires_on' => '2027-01-01',
            ]);

        $response->assertRedirect(route('inventory.index'));
        $this->assertDatabaseHas('medicines', [
            'name' => 'Aspirin',
            'sku' => 'MED-001',
        ]);
        $this->assertDatabaseHas('pharmacy_inventory_items', [
            'pharmacy_id' => $pharmacy->id,
            'quantity' => 15,
            'minimum_quantity' => 4,
        ]);
    }

    public function test_authenticated_user_cannot_add_same_medicine_to_same_pharmacy_twice(): void
    {
        $user = User::factory()->create();
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
            'quantity' => 15,
            'minimum_quantity' => 4,
        ]);

        $response = $this
            ->actingAs($user)
            ->from(route('inventory.create'))
            ->post(route('inventory.store'), [
                'pharmacy_id' => $pharmacy->id,
                'medicine_name' => 'Aspirin',
                'medicine_sku' => ' med-001 ',
                'unit' => 'pack',
                'quantity' => 10,
                'minimum_quantity' => 2,
            ]);

        $response
            ->assertRedirect(route('inventory.create'))
            ->assertSessionHasErrors('medicine_name');
    }
}
