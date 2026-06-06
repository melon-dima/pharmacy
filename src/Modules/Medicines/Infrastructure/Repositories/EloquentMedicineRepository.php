<?php

namespace Src\Modules\Medicines\Infrastructure\Repositories;

use App\Models\Medicine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Medicines\Domain\Repositories\MedicineRepositoryInterface;

class EloquentMedicineRepository implements MedicineRepositoryInterface
{
    public function paginate(int $perPage, ?string $search = null): LengthAwarePaginator
    {
        return Medicine::query()
            ->when($search !== null && trim($search) !== '', function ($query) use ($search): void {
                $search = trim($search);
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('manufacturer', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('dosage_form', 'like', "%{$search}%")
                        ->orWhere('external_id', 'like', "%{$search}%");
                });
            })
            ->withCount('inventoryItems')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function paginateByIds(array $medicineIds, int $perPage): LengthAwarePaginator
    {
        return Medicine::query()
            ->whereIn('id', $medicineIds === [] ? [-1] : $medicineIds)
            ->withCount('inventoryItems')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function loadForShow(Medicine $medicine): Medicine
    {
        return $medicine->load(['inventoryItems.pharmacy']);
    }

    public function skuExists(string $sku, ?int $ignoreMedicineId = null): bool
    {
        return Medicine::query()
            ->where('sku', $sku)
            ->when($ignoreMedicineId !== null, fn ($query) => $query->whereKeyNot($ignoreMedicineId))
            ->exists();
    }

    public function externalIdentityExists(string $system, string $externalId, ?int $ignoreMedicineId = null): bool
    {
        return Medicine::query()
            ->where('external_system', $system)
            ->where('external_id', $externalId)
            ->when($ignoreMedicineId !== null, fn ($query) => $query->whereKeyNot($ignoreMedicineId))
            ->exists();
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes): Medicine
    {
        return Medicine::query()->create($attributes);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function update(Medicine $medicine, array $attributes): Medicine
    {
        $medicine->update($attributes);

        return $medicine;
    }

    public function deactivate(Medicine $medicine): Medicine
    {
        $medicine->update(['is_active' => false]);

        return $medicine;
    }
}
