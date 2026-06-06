<?php

namespace Src\Modules\CustomerOrders\Actions;

use App\Models\CustomerOrder;
use Src\Modules\CustomerOrders\Services\CustomerOrderService;

class ShowCustomerOrderAction
{
    public function __construct(
        private readonly CustomerOrderService $service,
    ) {
    }

    public function handle(CustomerOrder $order): CustomerOrder
    {
        return $this->service->loadForShow($order);
    }
}
