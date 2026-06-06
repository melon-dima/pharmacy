<?php

namespace Src\Modules\Medicines\Services;

use App\Models\Medicine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Catalog\Domain\Repositories\CatalogSearchRepositoryInterface;
use Src\Modules\Medicines\Domain\Repositories\MedicineRepositoryInterface;
use Src\Modules\Medicines\Domain\Services\MedicineCatalogManagementService;
use Src\Modules\Medicines\DTO\MedicineData;

class MedicineService
{
    public function __construct(
        private readonly MedicineRepositoryInterface $medicines,
        private readonly MedicineCatalogManagementService $management,
        private readonly CatalogSearchRepositoryInterface $search,
    ) {
    }

    public function paginate(int $perPage = 20, ?string $query = null): LengthAwarePaginator
    {
        $query = $query === null ? null : trim($query);

        if ($query === null || $query === '') {
            return $this->medicines->paginate($perPage);
        }

        $medicineIds = $this->search->searchMedicineIds($query);
        if ($medicineIds !== null) {
            return $this->medicines->paginateByIds($medicineIds, $perPage);
        }

        return $this->medicines->paginate($perPage, $query);
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
