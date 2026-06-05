<?php

namespace Src\Modules\Employees\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Employees\Services\EmployeeService;

class ListEmployeesAction
{
    public function __construct(
        private readonly EmployeeService $employeeService,
    ) {
    }

    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return $this->employeeService->paginate($perPage);
    }
}
