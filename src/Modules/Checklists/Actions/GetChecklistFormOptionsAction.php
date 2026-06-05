<?php

namespace Src\Modules\Checklists\Actions;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Checklists\Services\ChecklistService;

class GetChecklistFormOptionsAction
{
    public function __construct(
        private readonly ChecklistService $service,
    ) {
    }

    /**
     * @return Collection<int, Pharmacy>
     */
    public function handle(): Collection
    {
        return $this->service->getFormPharmacies();
    }
}
