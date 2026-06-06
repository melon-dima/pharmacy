<?php

namespace Src\Modules\CustomerOrders\DTO;

class CreateCustomerOrderData
{
    /**
     * @param array<int, CreateCustomerOrderItemData> $items
     */
    public function __construct(
        public readonly string $deliveryType,
        public readonly ?int $pharmacyId,
        public readonly string $customerName,
        public readonly string $customerPhone,
        public readonly ?string $deliveryAddress,
        public readonly ?string $comment,
        public readonly array $items,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated): self
    {
        return new self(
            deliveryType: (string) $validated['delivery_type'],
            pharmacyId: isset($validated['pharmacy_id']) ? (int) $validated['pharmacy_id'] : null,
            customerName: (string) $validated['customer_name'],
            customerPhone: (string) $validated['customer_phone'],
            deliveryAddress: isset($validated['delivery_address']) ? (string) $validated['delivery_address'] : null,
            comment: isset($validated['comment']) ? (string) $validated['comment'] : null,
            items: array_map(
                fn (array $item): CreateCustomerOrderItemData => CreateCustomerOrderItemData::fromValidated($item),
                $validated['items'] ?? [],
            ),
        );
    }
}
