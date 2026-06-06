<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CustomerOrderResource;
use App\Models\CustomerOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Src\Modules\CustomerOrders\Actions\CreateCustomerOrderAction;
use Src\Modules\CustomerOrders\Actions\ListCustomerOrdersAction;
use Src\Modules\CustomerOrders\Actions\ShowCustomerOrderAction;

class CustomerOrderController extends Controller
{
    public function __construct(
        private readonly ListCustomerOrdersAction $listCustomerOrdersAction,
        private readonly ShowCustomerOrderAction $showCustomerOrderAction,
        private readonly CreateCustomerOrderAction $createCustomerOrderAction,
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        return CustomerOrderResource::collection($this->listCustomerOrdersAction->handle($request->user(), 20));
    }

    public function store(Request $request): JsonResponse
    {
        $order = $this->createCustomerOrderAction->handle($request, $request->user());

        return CustomerOrderResource::make($order)
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, CustomerOrder $order): CustomerOrderResource
    {
        abort_unless($order->user_id === $request->user()->id, 404);

        return CustomerOrderResource::make($this->showCustomerOrderAction->handle($order));
    }
}
