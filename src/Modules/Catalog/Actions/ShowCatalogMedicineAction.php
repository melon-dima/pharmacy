<?php

namespace Src\Modules\Catalog\Actions;

use App\Models\Medicine;
use Src\Modules\Catalog\Services\CatalogService;

class ShowCatalogMedicineAction
{
    public function __construct(
        private readonly CatalogService $service,
    ) {
    }

    public function handle(Medicine $medicine): Medicine
    {
        return $this->service->loadMedicine($medicine);
    }
}
