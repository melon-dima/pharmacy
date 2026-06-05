<?php

namespace Src\Modules\EmployeeRequests\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\EmployeeRequests\Services\EmployeeRequestService;

class ListEmployeeRequestsAction
{
    public function __construct(
        private readonly EmployeeRequestService $service,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
