<?php

namespace Src\Modules\Catalog\Services;

use App\Models\Medicine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Catalog\Domain\Repositories\CatalogRepositoryInterface;
use Src\Modules\Catalog\Domain\Repositories\CatalogSearchRepositoryInterface;

class CatalogService
{
    public function __construct(
        private readonly CatalogRepositoryInterface $catalog,
        private readonly CatalogSearchRepositoryInterface $search,
    ) {
    }

    public function paginateMedicines(int $perPage = 20, ?string $query = null): LengthAwarePaginator
    {
        $query = $query === null ? null : trim($query);

        if ($query === null || $query === '') {
            return $this->catalog->paginateActiveMedicines($perPage);
        }

        $medicineIds = $this->search->searchMedicineIds($query);
        if ($medicineIds !== null) {
            return $this->catalog->paginateActiveMedicinesByIds($medicineIds, $perPage);
        }

        return $this->catalog->paginateActiveMedicines($perPage, $query);
    }

    public function loadMedicine(Medicine $medicine): Medicine
    {
        return $this->catalog->loadActiveMedicine($medicine);
    }

    /**
     * @return Collection<int, \App\Models\Pharmacy>
     */
    public function activePharmacies(): Collection
    {
        return $this->catalog->activePharmacies();
    }
}
