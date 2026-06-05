<?php

namespace Src\Modules\Schedules\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Schedules\Services\ScheduleService;

class ListSchedulesAction
{
    public function __construct(
        private readonly ScheduleService $service,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
