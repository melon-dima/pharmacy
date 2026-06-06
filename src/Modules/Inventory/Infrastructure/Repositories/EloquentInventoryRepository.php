<?php

namespace Src\Modules\Inventory\Infrastructure\Repositories;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventoryItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Inventory\Domain\Repositories\InventoryRepositoryInterface;

class EloquentInventoryRepository implements InventoryRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return PharmacyInventoryItem::query()
            ->with(['pharmacy', 'medicine'])
            ->orderByDesc('updated_at')
            ->paginate($perPage);
    }

    public function loadForShow(PharmacyInventoryItem $item): PharmacyInventoryItem
    {
        return $item->load(['pharmacy', 'medicine']);
    }

    public function activePharmacies(): Collection
    {
        return Pharmacy::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function findPharmacy(int $pharmacyId): ?Pharmacy
    {
        return Pharmacy::query()->find($pharmacyId);
    }

    public function findMedicineBySku(string $sku): ?Medicine
    {
        return Medicine::query()->where('sku', $sku)->first();
    }

    public function findMedicineByName(string $name): ?Medicine
    {
        return Medicine::query()->where('name', $name)->first();
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function createMedicine(array $attributes): Medicine
    {
        return Medicine::query()->create($attributes);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function updateMedicine(Medicine $medicine, array $attributes): Medicine
    {
        $medicine->update($attributes);

        return $medicine;
    }

    public function hasStockItem(int $pharmacyId, int $medicineId, ?int $ignoreItemId = null): bool
    {
        return PharmacyInventoryItem::query()
            ->where('pharmacy_id', $pharmacyId)
            ->where('medicine_id', $medicineId)
            ->when($ignoreItemId !== null, fn ($query) => $query->whereKeyNot($ignoreItemId))
            ->exists();
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function createStockItem(array $attributes): PharmacyInventoryItem
    {
        return PharmacyInventoryItem::query()->create($attributes);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function updateStockItem(PharmacyInventoryItem $item, array $attributes): PharmacyInventoryItem
    {
        $item->update($attributes);

        return $item;
    }
}
