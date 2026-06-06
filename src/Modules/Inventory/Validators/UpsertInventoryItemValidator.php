<?php

namespace Src\Modules\Inventory\Validators;

use Illuminate\Http\Request;
use Src\Modules\Inventory\DTO\InventoryItemData;

class UpsertInventoryItemValidator
{
    public function validate(Request $request): InventoryItemData
    {
        $validated = $request->validate([
            'pharmacy_id' => ['required', 'exists:pharmacies,id'],
            'medicine_name' => ['required', 'string', 'max:255'],
            'medicine_sku' => ['nullable', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'quantity' => ['required', 'integer', 'min:0'],
            'minimum_quantity' => ['nullable', 'integer', 'min:0'],
            'expires_on' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        return InventoryItemData::fromValidated($validated);
    }
}
