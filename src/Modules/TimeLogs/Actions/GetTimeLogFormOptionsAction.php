<?php

namespace Src\Modules\TimeLogs\Actions;

use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\TimeLogs\Services\TimeLogService;

class GetTimeLogFormOptionsAction
{
    public function __construct(
        private readonly TimeLogService $service,
    ) {
    }

    /**
     * @return array{employees: Collection<int, Employee>, shifts: Collection<int, Shift>}
     */
    public function handle(): array
    {
        return $this->service->getFormOptions();
    }
}
