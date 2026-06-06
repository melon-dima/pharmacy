<?php

namespace Src\Modules\CustomerOrders\Domain\Services;

use App\Models\CustomerOrder;
use App\Models\User;
use Src\Modules\Analytics\Domain\AnalyticsEventRecorderInterface;
use Src\Modules\Analytics\DTO\AnalyticsEventData;
use Src\Modules\CustomerOrders\Domain\Exceptions\CannotOrderInactivePharmacy;
use Src\Modules\CustomerOrders\Domain\Exceptions\EmptyCustomerOrder;
use Src\Modules\CustomerOrders\Domain\Exceptions\MedicineUnavailableForPickup;
use Src\Modules\CustomerOrders\Domain\Exceptions\MissingDeliveryAddress;
use Src\Modules\CustomerOrders\Domain\Exceptions\MissingPickupPharmacy;
use Src\Modules\CustomerOrders\Domain\Repositories\CustomerOrderRepositoryInterface;
use Src\Modules\CustomerOrders\Domain\ValueObjects\DeliveryType;
use Src\Modules\CustomerOrders\Domain\ValueObjects\OrderQuantity;
use Src\Modules\CustomerOrders\Domain\ValueObjects\OrderStatus;
use Src\Modules\CustomerOrders\DTO\CreateCustomerOrderData;

class CustomerOrderPlacementService
{
    public function __construct(
        private readonly CustomerOrderRepositoryInterface $orders,
        private readonly AnalyticsEventRecorderInterface $analytics,
    ) {
    }

    public function place(User $user, CreateCustomerOrderData $data): CustomerOrder
    {
        if ($data->items === []) {
            throw new EmptyCustomerOrder('В заказе должно быть хотя бы одно лекарство.');
        }

        $deliveryType = DeliveryType::from($data->deliveryType);
        if ($deliveryType === DeliveryType::Pickup && $data->pharmacyId === null) {
            throw new MissingPickupPharmacy('Для самовывоза нужно выбрать аптеку.');
        }

        if ($deliveryType === DeliveryType::HomeDelivery && trim((string) $data->deliveryAddress) === '') {
            throw new MissingDeliveryAddress('Для доставки на дом нужно указать адрес.');
        }

        if ($data->pharmacyId !== null) {
            $pharmacy = $this->orders->findPharmacy($data->pharmacyId);
            if ($pharmacy === null || ! $pharmacy->is_active) {
                throw new CannotOrderInactivePharmacy('Нельзя оформить заказ в неактивную аптеку.');
            }
        }

        $items = [];
        $totalCents = 0;
        $currency = 'RUB';
        foreach ($data->items as $itemData) {
            $quantity = (new OrderQuantity($itemData->quantity))->value();
            $medicine = $this->orders->findMedicine($itemData->medicineId);

            if ($medicine === null || ! $medicine->is_active) {
                throw new MedicineUnavailableForPickup('Лекарство недоступно для заказа.');
            }

            if ($deliveryType === DeliveryType::Pickup && $data->pharmacyId !== null) {
                $available = $this->orders->availableQuantity($data->pharmacyId, $medicine->id);
                if ($available < $quantity) {
                    throw new MedicineUnavailableForPickup("Недостаточно лекарства {$medicine->name} в выбранной аптеке.");
                }
            }

            $unitPriceCents = (int) ($medicine->price_cents ?? 0);
            $currency = (string) ($medicine->currency ?? $currency);
            $totalCents += $unitPriceCents * $quantity;

            $items[] = [
                'medicine_id' => $medicine->id,
                'medicine_name' => $medicine->name,
                'medicine_sku' => $medicine->sku,
                'quantity' => $quantity,
                'unit_price_cents' => $unitPriceCents,
                'currency' => $currency,
            ];
        }

        $order = $this->orders->create($user, [
            'pharmacy_id' => $data->pharmacyId,
            'delivery_type' => $deliveryType->value,
            'status' => OrderStatus::Pending->value,
            'customer_name' => trim($data->customerName),
            'customer_phone' => trim($data->customerPhone),
            'delivery_address' => $data->deliveryAddress === null ? null : trim($data->deliveryAddress),
            'total_cents' => $totalCents,
            'currency' => $currency,
            'comment' => $data->comment === null ? null : trim($data->comment),
        ], $items);

        $this->analytics->record(new AnalyticsEventData(
            eventName: 'customer_order_created',
            actorId: $user->id,
            subjectType: 'customer_order',
            subjectId: $order->id,
            payload: [
                'delivery_type' => $deliveryType->value,
                'pharmacy_id' => $data->pharmacyId,
                'total_cents' => $totalCents,
                'currency' => $currency,
                'items_count' => count($items),
            ],
        ));

        return $order;
    }
}
