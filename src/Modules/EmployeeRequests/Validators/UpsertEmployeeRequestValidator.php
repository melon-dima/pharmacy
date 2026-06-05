<?php

namespace Src\Modules\EmployeeRequests\Validators;

use Illuminate\Http\Request;
use Src\Modules\EmployeeRequests\DTO\EmployeeRequestData;

class UpsertEmployeeRequestValidator
{
    public function validate(Request $request): EmployeeRequestData
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'type' => ['required', 'string', 'max:255'],
            'starts_on' => ['nullable', 'date'],
            'ends_on' => ['nullable', 'date'],
            'reason' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:100'],
            'approved_by_user_id' => ['nullable', 'exists:users,id'],
            'decided_at' => ['nullable', 'date'],
        ]);

        return EmployeeRequestData::fromValidated($validated);
    }
}
