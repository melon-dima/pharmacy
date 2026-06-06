<?php

namespace Src\Modules\Medicines\Validators;

use Illuminate\Http\Request;
use Src\Modules\Medicines\DTO\MedicineData;

class UpsertMedicineValidator
{
    public function validate(Request $request): MedicineData
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'dosage_form' => ['nullable', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'is_active' => ['nullable', 'boolean'],
            'external_system' => ['nullable', 'string', 'max:255'],
            'external_id' => ['nullable', 'string', 'max:255'],
        ]);

        return MedicineData::fromValidated($validated, $request->boolean('is_active'));
    }
}
