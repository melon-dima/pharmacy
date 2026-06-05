<?php

namespace Src\Modules\Exchanges\Validators;

use Illuminate\Http\Request;
use Src\Modules\Exchanges\DTO\ExchangeData;

class UpsertExchangeValidator
{
    public function validate(Request $request): ExchangeData
    {
        $validated = $request->validate([
            'system' => ['required', 'string', 'max:255'],
            'direction' => ['required', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:100'],
            'payload' => ['nullable', 'json'],
            'response' => ['nullable', 'string'],
            'exchanged_at' => ['nullable', 'date'],
        ]);

        return ExchangeData::fromValidated($validated);
    }
}
