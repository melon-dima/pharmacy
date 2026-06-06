<?php

namespace Src\Modules\Inventory\DTO;

class InventoryItemData
{
    public function __construct(
        public readonly int $pharmacyId,
        public readonly string $medicineName,
        public readonly ?string $medicineSku,
        public readonly ?string $manufacturer,
        public readonly string $unit,
        public readonly int $quantity,
        public readonly int $minimumQuantity,
        public readonly ?string $expiresOn,
        public readonly ?string $notes,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        return new self(
            pharmacyId: (int) $validated['pharmacy_id'],
            medicineName: (string) $validated['medicine_name'],
            medicineSku: isset($validated['medicine_sku']) ? (string) $validated['medicine_sku'] : null,
            manufacturer: isset($validated['manufacturer']) ? (string) $validated['manufacturer'] : null,
            unit: isset($validated['unit']) ? (string) $validated['unit'] : 'pcs',
            quantity: (int) $validated['quantity'],
            minimumQuantity: (int) ($validated['minimum_quantity'] ?? 0),
            expiresOn: isset($validated['expires_on']) ? (string) $validated['expires_on'] : null,
            notes: isset($validated['notes']) ? (string) $validated['notes'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function stockAttributes(int $medicineId): array
    {
        return [
            'pharmacy_id' => $this->pharmacyId,
            'medicine_id' => $medicineId,
            'quantity' => $this->quantity,
            'minimum_quantity' => $this->minimumQuantity,
            'expires_on' => $this->expiresOn,
            'notes' => $this->notes,
        ];
    }
}
