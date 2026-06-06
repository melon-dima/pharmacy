<?php

namespace Src\Modules\Medicines\Actions;

use App\Models\Medicine;
use Src\Modules\Medicines\Services\MedicineService;

class ShowMedicineAction
{
    public function __construct(
        private readonly MedicineService $service,
    ) {
    }

    public function handle(Medicine $medicine): Medicine
    {
        return $this->service->loadForShow($medicine);
    }
}
