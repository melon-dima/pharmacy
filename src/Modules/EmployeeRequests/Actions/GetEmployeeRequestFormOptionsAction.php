<?php

namespace Src\Modules\EmployeeRequests\Actions;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\EmployeeRequests\Services\EmployeeRequestService;

class GetEmployeeRequestFormOptionsAction
{
    public function __construct(
        private readonly EmployeeRequestService $service,
    ) {
    }

    /**
     * @return array{employees: Collection<int, Employee>, users: Collection<int, User>}
     */
    public function handle(): array
    {
        return $this->service->getFormOptions();
    }
}
