<?php

namespace Src\Modules\Employees\Actions;

use App\Models\Employee;
use Src\Modules\Employees\Services\EmployeeService;

class ShowEmployeeAction
{
    public function __construct(
        private readonly EmployeeService $employeeService,
    ) {
    }

    public function handle(Employee $employee): Employee
    {
        return $this->employeeService->loadForShow($employee);
    }
}
