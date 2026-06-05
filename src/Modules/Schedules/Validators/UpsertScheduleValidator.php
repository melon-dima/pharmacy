<?php

namespace Src\Modules\Schedules\Validators;

use Illuminate\Http\Request;
use Src\Modules\Schedules\DTO\ScheduleData;

class UpsertScheduleValidator
{
    public function validate(Request $request): ScheduleData
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'pharmacy_id' => ['required', 'exists:pharmacies,id'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'status' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        return ScheduleData::fromValidated($validated);
    }
}
