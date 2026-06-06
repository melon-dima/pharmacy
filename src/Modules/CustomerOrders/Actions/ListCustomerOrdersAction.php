<?php

namespace Src\Modules\CustomerOrders\Actions;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\CustomerOrders\Services\CustomerOrderService;

class ListCustomerOrdersAction
{
    public function __construct(
        private readonly CustomerOrderService $service,
    ) {
    }

    public function handle(User $user, int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginateForUser($user, $perPage);
    }
}
