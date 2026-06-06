<?php

namespace Tests\Unit\Modules\Medicines;

use App\Models\Medicine;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Modules\Medicines\Domain\Exceptions\DuplicateMedicineExternalIdentity;
use Src\Modules\Medicines\Domain\Exceptions\DuplicateMedicineSku;
use Src\Modules\Medicines\Domain\Repositories\MedicineRepositoryInterface;
use Src\Modules\Medicines\Domain\Services\MedicineCatalogManagementService;
use Src\Modules\Medicines\DTO\MedicineData;

class MedicineCatalogManagementServiceTest extends TestCase
{
    private MedicineRepositoryInterface&MockObject $repository;

    private MedicineCatalogManagementService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(MedicineRepositoryInterface::class);
        $this->service = new MedicineCatalogManagementService($this->repository);
    }

    public function test_create_normalizes_catalog_fields_before_persisting(): void
    {
        $data = new MedicineData(
            name: ' Aspirin ',
            sku: ' med-001 ',
            manufacturer: ' Acme ',
            description: ' Pain relief ',
            dosageForm: ' tablets ',
            unit: ' pack ',
            priceCents: 12345,
            currency: 'rub',
            isActive: true,
            externalSystem: ' 1C ',
            externalId: ' 0001 ',
        );
        $medicine = new Medicine();

        $this->repository
            ->expects($this->once())
            ->method('skuExists')
            ->with('MED-001', null)
            ->willReturn(false);

        $this->repository
            ->expects($this->once())
            ->method('externalIdentityExists')
            ->with('1c', '0001', null)
            ->willReturn(false);

        $this->repository
            ->expects($this->once())
            ->method('create')
            ->with([
                'name' => 'Aspirin',
                'sku' => 'MED-001',
                'manufacturer' => 'Acme',
                'description' => 'Pain relief',
                'dosage_form' => 'tablets',
                'unit' => 'pack',
                'price_cents' => 12345,
                'currency' => 'RUB',
                'is_active' => true,
                'external_system' => '1c',
                'external_id' => '0001',
            ])
            ->willReturn($medicine);

        $this->assertSame($medicine, $this->service->create($data));
    }

    public function test_create_rejects_duplicate_sku(): void
    {
        $data = new MedicineData(
            name: 'Aspirin',
            sku: 'MED-001',
            manufacturer: null,
            description: null,
            dosageForm: null,
            unit: 'pack',
            priceCents: 1000,
            currency: 'RUB',
            isActive: true,
            externalSystem: null,
            externalId: null,
        );

        $this->repository
            ->expects($this->once())
            ->method('skuExists')
            ->with('MED-001', null)
            ->willReturn(true);

        $this->repository
            ->expects($this->never())
            ->method('create');

        $this->expectException(DuplicateMedicineSku::class);

        $this->service->create($data);
    }

    public function test_create_rejects_duplicate_external_identity(): void
    {
        $data = new MedicineData(
            name: 'Aspirin',
            sku: null,
            manufacturer: null,
            description: null,
            dosageForm: null,
            unit: 'pack',
            priceCents: 1000,
            currency: 'RUB',
            isActive: true,
            externalSystem: '1c',
            externalId: '0001',
        );

        $this->repository
            ->expects($this->once())
            ->method('externalIdentityExists')
            ->with('1c', '0001', null)
            ->willReturn(true);

        $this->repository
            ->expects($this->never())
            ->method('create');

        $this->expectException(DuplicateMedicineExternalIdentity::class);

        $this->service->create($data);
    }
}
