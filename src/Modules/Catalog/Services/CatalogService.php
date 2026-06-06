<?php

namespace Src\Modules\Catalog\Services;

use App\Models\Medicine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Catalog\Domain\Repositories\CatalogRepositoryInterface;

class CatalogService
{
    public function __construct(
        private readonly CatalogRepositoryInterface $catalog,
    ) {
    }

    public function paginateMedicines(int $perPage = 20): LengthAwarePaginator
    {
        return $this->catalog->paginateActiveMedicines($perPage);
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
