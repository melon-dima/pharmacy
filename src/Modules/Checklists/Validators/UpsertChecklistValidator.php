<?php

namespace Src\Modules\Checklists\Validators;

use Illuminate\Http\Request;
use Src\Modules\Checklists\DTO\ChecklistData;

class UpsertChecklistValidator
{
    public function validate(Request $request): ChecklistData
    {
        $validated = $request->validate([
            'pharmacy_id' => ['nullable', 'exists:pharmacies,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'frequency' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return ChecklistData::fromValidated($validated, $request->boolean('is_active'));
    }
}
