<?php

namespace Src\Modules\Pharmacies\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Pharmacies\Services\PharmacyService;

class ListPharmaciesAction
{
    public function __construct(
        private readonly PharmacyService $service,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
