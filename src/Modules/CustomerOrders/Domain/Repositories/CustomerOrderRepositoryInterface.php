<?php

namespace Src\Modules\CustomerOrders\Domain\Repositories;

use App\Models\CustomerOrder;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CustomerOrderRepositoryInterface
{
    public function paginateForUser(User $user, int $perPage): LengthAwarePaginator;

    public function loadForShow(CustomerOrder $order): CustomerOrder;

    public function findPharmacy(int $pharmacyId): ?Pharmacy;

    public function findMedicine(int $medicineId): ?Medicine;

    public function availableQuantity(int $pharmacyId, int $medicineId): int;

    /**
     * @param array<string, mixed> $orderAttributes
     * @param array<int, array<string, mixed>> $items
     */
    public function create(User $user, array $orderAttributes, array $items): CustomerOrder;
}
