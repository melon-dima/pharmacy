<?php

namespace Src\Modules\Medicines\Services;

use App\Models\Medicine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Medicines\Domain\Repositories\MedicineRepositoryInterface;
use Src\Modules\Medicines\Domain\Services\MedicineCatalogManagementService;
use Src\Modules\Medicines\DTO\MedicineData;

class MedicineService
{
    public function __construct(
        private readonly MedicineRepositoryInterface $medicines,
        private readonly MedicineCatalogManagementService $management,
    ) {
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->medicines->paginate($perPage);
    }

    public function loadForShow(Medicine $medicine): Medicine
    {
        return $this->medicines->loadForShow($medicine);
    }

    public function create(MedicineData $data): Medicine
    {
        return $this->management->create($data);
    }

    public function update(Medicine $medicine, MedicineData $data): Medicine
    {
        return $this->management->update($medicine, $data);
    }

    public function deactivate(Medicine $medicine): Medicine
    {
        return $this->management->deactivate($medicine);
    }
}
