<?php

namespace Src\Modules\Pharmacies\Validators;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Src\Modules\Pharmacies\DTO\PharmacyData;

class UpsertPharmacyValidator
{
    public function validateForCreate(Request $request): PharmacyData
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255', Rule::unique('pharmacies', 'code')],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return PharmacyData::fromValidated($validated, $request->boolean('is_active'));
    }

    public function validateForUpdate(Request $request, Pharmacy $pharmacy): PharmacyData
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255', Rule::unique('pharmacies', 'code')->ignore($pharmacy->id)],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return PharmacyData::fromValidated($validated, $request->boolean('is_active'));
    }
}
