<?php

namespace Src\Modules\TimeLogs\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\TimeLogs\Services\TimeLogService;

class ListTimeLogsAction
{
    public function __construct(
        private readonly TimeLogService $service,
    ) {
    }

    public function handle(int $perPage = 30): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
