<?php

namespace Src\Modules\CustomerOrders\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Src\Modules\CustomerOrders\Domain\ValueObjects\DeliveryType;
use Src\Modules\CustomerOrders\DTO\CreateCustomerOrderData;

class CreateCustomerOrderValidator
{
    public function validate(Request $request): CreateCustomerOrderData
    {
        $validated = $request->validate([
            'delivery_type' => ['required', Rule::enum(DeliveryType::class)],
            'pharmacy_id' => ['nullable', 'exists:pharmacies,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:255'],
            'delivery_address' => ['nullable', 'string', 'max:255'],
            'comment' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.medicine_id' => ['required', 'exists:medicines,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        return CreateCustomerOrderData::fromValidated($validated);
    }
}
