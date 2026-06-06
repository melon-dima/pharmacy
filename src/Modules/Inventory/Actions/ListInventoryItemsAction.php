<?php

namespace Src\Modules\Inventory\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Inventory\Services\InventoryService;

class ListInventoryItemsAction
{
    public function __construct(
        private readonly InventoryService $service,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
