<?php

namespace Src\Modules\Inventory\Domain\Services;

use App\Models\Medicine;
use App\Models\PharmacyInventoryItem;
use Src\Modules\Inventory\Domain\Exceptions\CannotTrackInactiveMedicine;
use Src\Modules\Inventory\Domain\Exceptions\CannotTrackInactivePharmacy;
use Src\Modules\Inventory\Domain\Exceptions\DuplicateInventoryItem;
use Src\Modules\Inventory\Domain\Repositories\InventoryRepositoryInterface;
use Src\Modules\Inventory\Domain\ValueObjects\InventoryQuantity;
use Src\Modules\Inventory\Domain\ValueObjects\MedicineSku;
use Src\Modules\Inventory\DTO\InventoryItemData;

class InventoryAccountingService
{
    public function __construct(
        private readonly InventoryRepositoryInterface $inventory,
    ) {
    }

    public function create(InventoryItemData $data): PharmacyInventoryItem
    {
        $pharmacy = $this->inventory->findPharmacy($data->pharmacyId);
        if ($pharmacy === null || ! $pharmacy->is_active) {
            throw new CannotTrackInactivePharmacy('Нельзя вести учет для неактивной аптеки.');
        }

        $medicine = $this->resolveMedicine($data);
        if (! $medicine->is_active) {
            throw new CannotTrackInactiveMedicine('Нельзя вести учет неактивного лекарства.');
        }

        $this->ensureStockItemIsUnique($data->pharmacyId, $medicine->id);

        return $this->inventory->createStockItem($this->stockPayload($data, $medicine));
    }

    public function update(PharmacyInventoryItem $item, InventoryItemData $data): PharmacyInventoryItem
    {
        $pharmacy = $this->inventory->findPharmacy($data->pharmacyId);
        if ($pharmacy === null || ! $pharmacy->is_active) {
            throw new CannotTrackInactivePharmacy('Нельзя вести учет для неактивной аптеки.');
        }

        $medicine = $this->resolveMedicine($data, $item->medicine);
        if (! $medicine->is_active) {
            throw new CannotTrackInactiveMedicine('Нельзя вести учет неактивного лекарства.');
        }

        $this->ensureStockItemIsUnique($data->pharmacyId, $medicine->id, $item->id);

        return $this->inventory->updateStockItem($item, $this->stockPayload($data, $medicine));
    }

    private function resolveMedicine(InventoryItemData $data, ?Medicine $currentMedicine = null): Medicine
    {
        $sku = (new MedicineSku($data->medicineSku))->value();
        $medicine = $sku === null
            ? $this->inventory->findMedicineByName(trim($data->medicineName))
            : $this->inventory->findMedicineBySku($sku);

        if ($medicine === null) {
            return $this->inventory->createMedicine($this->medicinePayload($data, $sku));
        }

        if ($currentMedicine !== null && $currentMedicine->is($medicine)) {
            return $this->inventory->updateMedicine($medicine, $this->medicinePayload($data, $sku));
        }

        return $medicine;
    }

    private function ensureStockItemIsUnique(int $pharmacyId, int $medicineId, ?int $ignoreItemId = null): void
    {
        if ($this->inventory->hasStockItem($pharmacyId, $medicineId, $ignoreItemId)) {
            throw new DuplicateInventoryItem('Это лекарство уже есть в учете выбранной аптеки.');
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function medicinePayload(InventoryItemData $data, ?string $sku): array
    {
        return [
            'name' => trim($data->medicineName),
            'sku' => $sku,
            'manufacturer' => $data->manufacturer === null ? null : trim($data->manufacturer),
            'unit' => trim($data->unit),
            'is_active' => true,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function stockPayload(InventoryItemData $data, Medicine $medicine): array
    {
        return array_replace($data->stockAttributes($medicine->id), [
            'quantity' => (new InventoryQuantity($data->quantity))->value(),
            'minimum_quantity' => (new InventoryQuantity($data->minimumQuantity))->value(),
        ]);
    }
}
