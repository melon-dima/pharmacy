<?php

namespace Src\Modules\Employees\Validators;

use Illuminate\Http\Request;
use Src\Modules\Employees\DTO\EmployeeData;

class UpsertEmployeeValidator
{
    public function validate(Request $request): EmployeeData
    {
        $validated = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'pharmacy_id' => ['nullable', 'exists:pharmacies,id'],
            'full_name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'hired_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return EmployeeData::fromValidated($validated, $request->boolean('is_active'));
    }
}
