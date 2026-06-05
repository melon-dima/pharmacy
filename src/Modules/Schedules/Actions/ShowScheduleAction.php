<?php

namespace Src\Modules\Schedules\Actions;

use App\Models\Shift;
use Src\Modules\Schedules\Services\ScheduleService;

class ShowScheduleAction
{
    public function __construct(
        private readonly ScheduleService $service,
    ) {
    }

    public function handle(Shift $shift): Shift
    {
        return $this->service->loadForShow($shift);
    }
}
