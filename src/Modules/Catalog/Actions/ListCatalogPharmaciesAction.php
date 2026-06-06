<?php

namespace Src\Modules\Catalog\Actions;

use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Catalog\Services\CatalogService;

class ListCatalogPharmaciesAction
{
    public function __construct(
        private readonly CatalogService $service,
    ) {
    }

    /**
     * @return Collection<int, \App\Models\Pharmacy>
     */
    public function handle(): Collection
    {
        return $this->service->activePharmacies();
    }
}
