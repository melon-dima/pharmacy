<?php

namespace Tests\Feature\Modules\Inventory;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Modules\Inventory\Infrastructure\Repositories\EloquentInventoryRepository;
use Tests\TestCase;

class EloquentInventoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentInventoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new EloquentInventoryRepository();
    }

    public function test_active_pharmacies_returns_only_active_pharmacies(): void
    {
        Pharmacy::query()->create(['name' => 'Inactive Pharmacy', 'is_active' => false]);
        Pharmacy::query()->create(['name' => 'Active Pharmacy', 'is_active' => true]);

        $pharmacies = $this->repository->activePharmacies();

        $this->assertCount(1, $pharmacies);
        $this->assertSame('Active Pharmacy', $pharmacies->first()->name);
    }

    public function test_has_stock_item_checks_pharmacy_and_medicine_pair(): void
    {
        $pharmacy = Pharmacy::query()->create(['name' => 'Central Pharmacy']);
        $otherPharmacy = Pharmacy::query()->create(['name' => 'Other Pharmacy']);
        $medicine = Medicine::query()->create(['name' => 'Aspirin', 'sku' => 'MED-001']);
        $item = PharmacyInventoryItem::query()->create([
            'pharmacy_id' => $pharmacy->id,
            'medicine_id' => $medicine->id,
            'quantity' => 10,
            'minimum_quantity' => 2,
        ]);

        $this->assertTrue($this->repository->hasStockItem($pharmacy->id, $medicine->id));
        $this->assertFalse($this->repository->hasStockItem($pharmacy->id, $medicine->id, $item->id));
        $this->assertFalse($this->repository->hasStockItem($otherPharmacy->id, $medicine->id));
    }
}
