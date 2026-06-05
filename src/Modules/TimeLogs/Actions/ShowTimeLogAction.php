<?php

namespace Src\Modules\TimeLogs\Actions;

use App\Models\TimeLog;
use Src\Modules\TimeLogs\Services\TimeLogService;

class ShowTimeLogAction
{
    public function __construct(
        private readonly TimeLogService $service,
    ) {
    }

    public function handle(TimeLog $timeLog): TimeLog
    {
        return $this->service->loadForShow($timeLog);
    }
}
