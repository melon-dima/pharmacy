<?php

namespace Tests\Unit\Modules\Inventory;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventoryItem;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Modules\Inventory\Domain\Exceptions\CannotTrackInactivePharmacy;
use Src\Modules\Inventory\Domain\Exceptions\DuplicateInventoryItem;
use Src\Modules\Inventory\Domain\Repositories\InventoryRepositoryInterface;
use Src\Modules\Inventory\Domain\Services\InventoryAccountingService;
use Src\Modules\Inventory\DTO\InventoryItemData;

class InventoryAccountingServiceTest extends TestCase
{
    private InventoryRepositoryInterface&MockObject $repository;

    private InventoryAccountingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(InventoryRepositoryInterface::class);
        $this->service = new InventoryAccountingService($this->repository);
    }

    public function test_create_normalizes_sku_and_creates_medicine_stock_item(): void
    {
        $data = new InventoryItemData(
            pharmacyId: 5,
            medicineName: 'Aspirin',
            medicineSku: ' med-001 ',
            manufacturer: 'Acme',
            unit: 'pack',
            quantity: 12,
            minimumQuantity: 3,
            expiresOn: '2027-01-01',
            notes: 'Shelf A',
        );
        $pharmacy = new Pharmacy(['is_active' => true]);
        $pharmacy->id = 5;
        $medicine = new Medicine(['is_active' => true]);
        $medicine->id = 7;
        $item = new PharmacyInventoryItem();

        $this->repository
            ->expects($this->once())
            ->method('findPharmacy')
            ->with(5)
            ->willReturn($pharmacy);

        $this->repository
            ->expects($this->once())
            ->method('findMedicineBySku')
            ->with('MED-001')
            ->willReturn(null);

        $this->repository
            ->expects($this->once())
            ->method('createMedicine')
            ->with([
                'name' => 'Aspirin',
                'sku' => 'MED-001',
                'manufacturer' => 'Acme',
                'unit' => 'pack',
                'is_active' => true,
            ])
            ->willReturn($medicine);

        $this->repository
            ->expects($this->once())
            ->method('hasStockItem')
            ->with(5, 7, null)
            ->willReturn(false);

        $this->repository
            ->expects($this->once())
            ->method('createStockItem')
            ->with([
                'pharmacy_id' => 5,
                'medicine_id' => 7,
                'quantity' => 12,
                'minimum_quantity' => 3,
                'expires_on' => '2027-01-01',
                'notes' => 'Shelf A',
            ])
            ->willReturn($item);

        $this->assertSame($item, $this->service->create($data));
    }

    public function test_create_rejects_inactive_pharmacy(): void
    {
        $data = new InventoryItemData(
            pharmacyId: 5,
            medicineName: 'Aspirin',
            medicineSku: null,
            manufacturer: null,
            unit: 'pack',
            quantity: 12,
            minimumQuantity: 3,
            expiresOn: null,
            notes: null,
        );
        $pharmacy = new Pharmacy(['is_active' => false]);
        $pharmacy->id = 5;

        $this->repository
            ->expects($this->once())
            ->method('findPharmacy')
            ->with(5)
            ->willReturn($pharmacy);

        $this->repository
            ->expects($this->never())
            ->method('createStockItem');

        $this->expectException(CannotTrackInactivePharmacy::class);

        $this->service->create($data);
    }

    public function test_create_rejects_duplicate_stock_item(): void
    {
        $data = new InventoryItemData(
            pharmacyId: 5,
            medicineName: 'Aspirin',
            medicineSku: 'MED-001',
            manufacturer: null,
            unit: 'pack',
            quantity: 12,
            minimumQuantity: 3,
            expiresOn: null,
            notes: null,
        );
        $pharmacy = new Pharmacy(['is_active' => true]);
        $pharmacy->id = 5;
        $medicine = new Medicine(['is_active' => true]);
        $medicine->id = 7;

        $this->repository
            ->method('findPharmacy')
            ->willReturn($pharmacy);

        $this->repository
            ->method('findMedicineBySku')
            ->willReturn($medicine);

        $this->repository
            ->expects($this->once())
            ->method('hasStockItem')
            ->with(5, 7, null)
            ->willReturn(true);

        $this->repository
            ->expects($this->never())
            ->method('createStockItem');

        $this->expectException(DuplicateInventoryItem::class);

        $this->service->create($data);
    }
}
