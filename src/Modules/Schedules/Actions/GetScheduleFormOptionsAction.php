<?php

namespace Src\Modules\Schedules\Actions;

use App\Models\Employee;
use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Schedules\Services\ScheduleService;

class GetScheduleFormOptionsAction
{
    public function __construct(
        private readonly ScheduleService $service,
    ) {
    }

    /**
     * @return array{employees: Collection<int, Employee>, pharmacies: Collection<int, Pharmacy>}
     */
    public function handle(): array
    {
        return $this->service->getFormOptions();
    }
}
