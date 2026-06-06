<?php

namespace Src\Modules\Catalog\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Catalog\Services\CatalogService;

class ListCatalogMedicinesAction
{
    public function __construct(
        private readonly CatalogService $service,
    ) {
    }

    public function handle(int $perPage = 20, ?string $query = null): LengthAwarePaginator
    {
        return $this->service->paginateMedicines($perPage, $query);
    }
}
