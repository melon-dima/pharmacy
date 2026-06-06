<?php

namespace Tests\Unit\Modules\Medicines;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Modules\Catalog\Domain\Repositories\CatalogSearchRepositoryInterface;
use Src\Modules\Medicines\Domain\Repositories\MedicineRepositoryInterface;
use Src\Modules\Medicines\Domain\Services\MedicineCatalogManagementService;
use Src\Modules\Medicines\Services\MedicineService;

class MedicineServiceTest extends TestCase
{
    private MedicineRepositoryInterface&MockObject $repository;

    private MedicineCatalogManagementService&MockObject $management;

    private CatalogSearchRepositoryInterface&MockObject $search;

    private MedicineService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(MedicineRepositoryInterface::class);
        $this->management = $this->createMock(MedicineCatalogManagementService::class);
        $this->search = $this->createMock(CatalogSearchRepositoryInterface::class);
        $this->service = new MedicineService($this->repository, $this->management, $this->search);
    }

    public function test_paginate_uses_elasticsearch_ids_when_search_backend_is_available(): void
    {
        $paginator = $this->createMock(LengthAwarePaginator::class);

        $this->search
            ->expects($this->once())
            ->method('searchMedicineIds')
            ->with('aspirin')
            ->willReturn([5, 9]);

        $this->repository
            ->expects($this->once())
            ->method('paginateByIds')
            ->with([5, 9], 20)
            ->willReturn($paginator);

        $this->repository
            ->expects($this->never())
            ->method('paginate');

        $this->assertSame($paginator, $this->service->paginate(20, 'aspirin'));
    }

    public function test_paginate_falls_back_to_sql_search_when_elasticsearch_is_unavailable(): void
    {
        $paginator = $this->createMock(LengthAwarePaginator::class);

        $this->search
            ->expects($this->once())
            ->method('searchMedicineIds')
            ->with('aspirin')
            ->willReturn(null);

        $this->repository
            ->expects($this->once())
            ->method('paginate')
            ->with(20, 'aspirin')
            ->willReturn($paginator);

        $this->assertSame($paginator, $this->service->paginate(20, 'aspirin'));
    }
}
