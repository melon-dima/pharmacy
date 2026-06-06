<?php

namespace Src\Modules\Inventory\Domain\Repositories;

use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventoryItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface InventoryRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator;

    public function loadForShow(PharmacyInventoryItem $item): PharmacyInventoryItem;

    /**
     * @return Collection<int, Pharmacy>
     */
    public function activePharmacies(): Collection;

    public function findPharmacy(int $pharmacyId): ?Pharmacy;

    public function findMedicineBySku(string $sku): ?Medicine;

    public function findMedicineByName(string $name): ?Medicine;

    /**
     * @param array<string, mixed> $attributes
     */
    public function createMedicine(array $attributes): Medicine;

    /**
     * @param array<string, mixed> $attributes
     */
    public function updateMedicine(Medicine $medicine, array $attributes): Medicine;

    public function hasStockItem(int $pharmacyId, int $medicineId, ?int $ignoreItemId = null): bool;

    /**
     * @param array<string, mixed> $attributes
     */
    public function createStockItem(array $attributes): PharmacyInventoryItem;

    /**
     * @param array<string, mixed> $attributes
     */
    public function updateStockItem(PharmacyInventoryItem $item, array $attributes): PharmacyInventoryItem;
}
