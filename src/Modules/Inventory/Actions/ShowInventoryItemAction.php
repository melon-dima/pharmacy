<?php

namespace Src\Modules\Inventory\Actions;

use App\Models\PharmacyInventoryItem;
use Src\Modules\Inventory\Services\InventoryService;

class ShowInventoryItemAction
{
    public function __construct(
        private readonly InventoryService $service,
    ) {
    }

    public function handle(PharmacyInventoryItem $item): PharmacyInventoryItem
    {
        return $this->service->loadForShow($item);
    }
}
