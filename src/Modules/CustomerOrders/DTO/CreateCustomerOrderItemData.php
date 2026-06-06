<?php

namespace Src\Modules\CustomerOrders\DTO;

class CreateCustomerOrderItemData
{
    public function __construct(
        public readonly int $medicineId,
        public readonly int $quantity,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        return new self(
            medicineId: (int) $validated['medicine_id'],
            quantity: (int) $validated['quantity'],
        );
    }
}
