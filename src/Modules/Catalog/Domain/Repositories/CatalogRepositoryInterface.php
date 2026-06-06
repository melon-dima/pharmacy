<?php

namespace Src\Modules\Catalog\Domain\Repositories;

use App\Models\Medicine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CatalogRepositoryInterface
{
    public function paginateActiveMedicines(int $perPage): LengthAwarePaginator;

    public function loadActiveMedicine(Medicine $medicine): Medicine;

    /**
     * @return Collection<int, \App\Models\Pharmacy>
     */
    public function activePharmacies(): Collection;
}
