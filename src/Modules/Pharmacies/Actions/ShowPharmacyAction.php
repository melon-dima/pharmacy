<?php

namespace Src\Modules\Pharmacies\Actions;

use App\Models\Pharmacy;
use Src\Modules\Pharmacies\Services\PharmacyService;

class ShowPharmacyAction
{
    public function __construct(
        private readonly PharmacyService $service,
    ) {
    }

    public function handle(Pharmacy $pharmacy): Pharmacy
    {
        return $this->service->loadForShow($pharmacy);
    }
}
