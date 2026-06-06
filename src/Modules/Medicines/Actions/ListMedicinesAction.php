<?php

namespace Src\Modules\Medicines\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Medicines\Services\MedicineService;

class ListMedicinesAction
{
    public function __construct(
        private readonly MedicineService $service,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
