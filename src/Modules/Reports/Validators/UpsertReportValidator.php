<?php

namespace Src\Modules\Reports\Validators;

use Illuminate\Http\Request;
use Src\Modules\Reports\DTO\ReportData;

class UpsertReportValidator
{
    public function validate(Request $request): ReportData
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'period_start' => ['nullable', 'date'],
            'period_end' => ['nullable', 'date'],
            'payload' => ['nullable', 'json'],
            'generated_by_user_id' => ['nullable', 'exists:users,id'],
            'generated_at' => ['nullable', 'date'],
        ]);

        return ReportData::fromValidated($validated);
    }
}
