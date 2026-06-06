<?php

namespace Src\Modules\CustomerOrders\Infrastructure\Repositories;

use App\Models\CustomerOrder;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmacyInventoryItem;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Src\Modules\CustomerOrders\Domain\Repositories\CustomerOrderRepositoryInterface;

class EloquentCustomerOrderRepository implements CustomerOrderRepositoryInterface
{
    public function paginateForUser(User $user, int $perPage): LengthAwarePaginator
    {
        return CustomerOrder::query()
            ->where('user_id', $user->id)
            ->with(['pharmacy', 'items.medicine'])
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function loadForShow(CustomerOrder $order): CustomerOrder
    {
        return $order->load(['pharmacy', 'items.medicine']);
    }

    public function findPharmacy(int $pharmacyId): ?Pharmacy
    {
        return Pharmacy::query()->find($pharmacyId);
    }

    public function findMedicine(int $medicineId): ?Medicine
    {
        return Medicine::query()->find($medicineId);
    }

    public function availableQuantity(int $pharmacyId, int $medicineId): int
    {
        return (int) PharmacyInventoryItem::query()
            ->where('pharmacy_id', $pharmacyId)
            ->where('medicine_id', $medicineId)
            ->value('quantity');
    }

    public function create(User $user, array $orderAttributes, array $items): CustomerOrder
    {
        return DB::transaction(function () use ($user, $orderAttributes, $items): CustomerOrder {
            $order = CustomerOrder::query()->create($orderAttributes + ['user_id' => $user->id]);
            $order->items()->createMany($items);

            return $this->loadForShow($order);
        });
    }
}
