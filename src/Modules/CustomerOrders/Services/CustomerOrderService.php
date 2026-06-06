<?php

namespace Src\Modules\CustomerOrders\Services;

use App\Models\CustomerOrder;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\CustomerOrders\Domain\Repositories\CustomerOrderRepositoryInterface;
use Src\Modules\CustomerOrders\Domain\Services\CustomerOrderPlacementService;
use Src\Modules\CustomerOrders\DTO\CreateCustomerOrderData;

class CustomerOrderService
{
    public function __construct(
        private readonly CustomerOrderRepositoryInterface $orders,
        private readonly CustomerOrderPlacementService $placement,
    ) {
    }

    public function paginateForUser(User $user, int $perPage = 20): LengthAwarePaginator
    {
        return $this->orders->paginateForUser($user, $perPage);
    }

    public function loadForShow(CustomerOrder $order): CustomerOrder
    {
        return $this->orders->loadForShow($order);
    }

    public function create(User $user, CreateCustomerOrderData $data): CustomerOrder
    {
        return $this->placement->place($user, $data);
    }
}
