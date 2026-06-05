<?php

namespace Src\Modules\Employees\Actions;

use App\Models\Employee;
use Illuminate\Http\Request;
use Src\Modules\Employees\Services\EmployeeService;
use Src\Modules\Employees\Validators\UpsertEmployeeValidator;

class CreateEmployeeAction
{
    public function __construct(
        private readonly UpsertEmployeeValidator $validator,
        private readonly EmployeeService $employeeService,
    ) {
    }

    public function handle(Request $request): Employee
    {
        $data = $this->validator->validate($request);

        return $this->employeeService->create($data);
    }
}
