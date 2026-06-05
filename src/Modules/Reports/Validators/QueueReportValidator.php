<?php

namespace Src\Modules\Reports\Validators;

use Illuminate\Http\Request;
use Src\Modules\Reports\DTO\QueueReportData;

class QueueReportValidator
{
    public function validate(Request $request): QueueReportData
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'period_start' => ['nullable', 'date'],
            'period_end' => ['nullable', 'date'],
            'generated_by_user_id' => ['nullable', 'exists:users,id'],
        ]);

        return QueueReportData::fromValidated($validated);
    }
}
