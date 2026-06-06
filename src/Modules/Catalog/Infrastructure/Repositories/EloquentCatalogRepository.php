<?php

namespace Src\Modules\Catalog\Infrastructure\Repositories;

use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Catalog\Domain\Repositories\CatalogRepositoryInterface;

class EloquentCatalogRepository implements CatalogRepositoryInterface
{
    public function paginateActiveMedicines(int $perPage): LengthAwarePaginator
    {
        return Medicine::query()
            ->where('is_active', true)
            ->withSum('inventoryItems as available_quantity', 'quantity')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function loadActiveMedicine(Medicine $medicine): Medicine
    {
        abort_unless($medicine->is_active, 404);

        return $medicine->load(['inventoryItems' => fn ($query) => $query->with('pharmacy')->whereHas('pharmacy', fn ($pharmacy) => $pharmacy->where('is_active', true))]);
    }

    public function activePharmacies(): Collection
    {
        return Pharmacy::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }
}
