<?php

namespace Src\Modules\EmployeeRequests\Actions;

use App\Models\EmployeeRequest;
use Src\Modules\EmployeeRequests\Services\EmployeeRequestService;

class ShowEmployeeRequestAction
{
    public function __construct(
        private readonly EmployeeRequestService $service,
    ) {
    }

    public function handle(EmployeeRequest $employeeRequest): EmployeeRequest
    {
        return $this->service->loadForShow($employeeRequest);
    }
}
