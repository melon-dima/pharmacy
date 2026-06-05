<?php

namespace Src\Modules\Employees\Actions;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Employees\Services\EmployeeService;

class GetEmployeeFormOptionsAction
{
    public function __construct(
        private readonly EmployeeService $employeeService,
    ) {
    }

    /**
     * @return array{pharmacies: Collection<int, Pharmacy>, users: Collection<int, User>}
     */
    public function handle(): array
    {
        return $this->employeeService->getFormOptions();
    }
}
