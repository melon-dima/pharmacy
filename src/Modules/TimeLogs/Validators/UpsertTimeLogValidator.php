<?php

namespace Src\Modules\TimeLogs\Validators;

use Illuminate\Http\Request;
use Src\Modules\TimeLogs\DTO\TimeLogData;

class UpsertTimeLogValidator
{
    public function validate(Request $request): TimeLogData
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'shift_id' => ['nullable', 'exists:shifts,id'],
            'logged_at' => ['required', 'date'],
            'type' => ['required', 'string', 'max:100'],
            'source' => ['nullable', 'string', 'max:255'],
            'meta' => ['nullable', 'json'],
        ]);

        return TimeLogData::fromValidated($validated);
    }
}
