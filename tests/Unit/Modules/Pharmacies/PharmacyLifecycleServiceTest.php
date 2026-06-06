<?php

namespace Tests\Unit\Modules\Pharmacies;

use App\Models\Pharmacy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Modules\Pharmacies\Domain\Exceptions\CannotDeactivatePharmacy;
use Src\Modules\Pharmacies\Domain\Exceptions\DuplicatePharmacyCode;
use Src\Modules\Pharmacies\Domain\Repositories\PharmacyRepositoryInterface;
use Src\Modules\Pharmacies\Domain\Services\PharmacyLifecycleService;
use Src\Modules\Pharmacies\DTO\PharmacyData;

class PharmacyLifecycleServiceTest extends TestCase
{
    private PharmacyRepositoryInterface&MockObject $repository;

    private PharmacyLifecycleService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(PharmacyRepositoryInterface::class);
        $this->service = new PharmacyLifecycleService($this->repository);
    }

    public function test_create_normalizes_code_before_persisting(): void
    {
        $data = new PharmacyData(
            name: 'Central Pharmacy',
            code: ' apt-001 ',
            address: 'Main street',
            phone: '+100000000',
            isActive: true,
        );
        $pharmacy = new Pharmacy();

        $this->repository
            ->expects($this->once())
            ->method('codeExists')
            ->with('APT-001', null)
            ->willReturn(false);

        $this->repository
            ->expects($this->once())
            ->method('create')
            ->with([
                'name' => 'Central Pharmacy',
                'code' => 'APT-001',
                'address' => 'Main street',
                'phone' => '+100000000',
                'is_active' => true,
            ])
            ->willReturn($pharmacy);

        $this->assertSame($pharmacy, $this->service->create($data));
    }

    public function test_create_rejects_duplicate_code(): void
    {
        $data = new PharmacyData(
            name: 'Central Pharmacy',
            code: 'APT-001',
            address: null,
            phone: null,
            isActive: true,
        );

        $this->repository
            ->expects($this->once())
            ->method('codeExists')
            ->with('APT-001', null)
            ->willReturn(true);

        $this->repository
            ->expects($this->never())
            ->method('create');

        $this->expectException(DuplicatePharmacyCode::class);

        $this->service->create($data);
    }

    public function test_update_rejects_deactivation_with_active_employees(): void
    {
        $pharmacy = new Pharmacy(['is_active' => true]);
        $pharmacy->id = 10;
        $data = new PharmacyData(
            name: 'Central Pharmacy',
            code: 'APT-001',
            address: null,
            phone: null,
            isActive: false,
        );

        $this->repository
            ->expects($this->once())
            ->method('codeExists')
            ->with('APT-001', 10)
            ->willReturn(false);

        $this->repository
            ->expects($this->once())
            ->method('hasActiveEmployees')
            ->with(10)
            ->willReturn(true);

        $this->repository
            ->expects($this->never())
            ->method('update');

        $this->expectException(CannotDeactivatePharmacy::class);

        $this->service->update($pharmacy, $data);
    }

    public function test_update_rejects_deactivation_with_future_shifts(): void
    {
        $pharmacy = new Pharmacy(['is_active' => true]);
        $pharmacy->id = 10;
        $data = new PharmacyData(
            name: 'Central Pharmacy',
            code: null,
            address: null,
            phone: null,
            isActive: false,
        );

        $this->repository
            ->expects($this->once())
            ->method('hasActiveEmployees')
            ->with(10)
            ->willReturn(false);

        $this->repository
            ->expects($this->once())
            ->method('hasFutureShifts')
            ->with(10)
            ->willReturn(true);

        $this->repository
            ->expects($this->never())
            ->method('update');

        $this->expectException(CannotDeactivatePharmacy::class);

        $this->service->update($pharmacy, $data);
    }
}
