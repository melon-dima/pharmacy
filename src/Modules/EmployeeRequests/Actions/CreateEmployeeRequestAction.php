<?php

namespace Src\Modules\EmployeeRequests\Actions;

use App\Models\EmployeeRequest;
use Illuminate\Http\Request;
use Src\Modules\EmployeeRequests\Services\EmployeeRequestService;
use Src\Modules\EmployeeRequests\Validators\UpsertEmployeeRequestValidator;

class CreateEmployeeRequestAction
{
    public function __construct(
        private readonly UpsertEmployeeRequestValidator $validator,
        private readonly EmployeeRequestService $service,
    ) {
    }

    public function handle(Request $request): EmployeeRequest
    {
        $data = $this->validator->validate($request);

        return $this->service->create($data);
    }
}
