<?php

namespace Tests\Feature\Api;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_mobile_catalog_lists_active_medicines_with_available_quantity(): void
    {
        $pharmacy = Pharmacy::query()->create([
            'name' => 'Central Pharmacy',
            'is_active' => true,
        ]);
        $medicine = Medicine::query()->create([
            'name' => 'Aspirin',
            'sku' => 'MED-001',
            'description' => 'Pain relief',
            'is_active' => true,
        ]);
        Medicine::query()->create([
            'name' => 'Inactive Medicine',
            'is_active' => false,
        ]);
        PharmacyInventoryItem::query()->create([
            'pharmacy_id' => $pharmacy->id,
            'medicine_id' => $medicine->id,
            'quantity' => 12,
            'minimum_quantity' => 2,
        ]);

        $response = $this->getJson('/api/v1/catalog/medicines');

        $response
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Aspirin')
            ->assertJsonPath('data.0.available_quantity', 12);
        $this->assertCount(1, $response->json('data'));
    }
}
