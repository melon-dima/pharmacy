<?php

namespace Src\Modules\Inventory\Actions;

use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Inventory\Services\InventoryService;

class GetInventoryFormOptionsAction
{
    public function __construct(
        private readonly InventoryService $service,
    ) {
    }

    /**
     * @return Collection<int, \App\Models\Pharmacy>
     */
    public function handle(): Collection
    {
        return $this->service->getFormPharmacies();
    }
}
