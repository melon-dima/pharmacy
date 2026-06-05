<?php

namespace Src\Modules\Settings\Validators;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Src\Modules\Settings\DTO\SettingData;

class UpsertSettingValidator
{
    public function validateForCreate(Request $request): SettingData
    {
        $validated = $request->validate([
            'group' => ['nullable', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:255', Rule::unique('system_settings', 'key')],
            'value' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        return SettingData::fromValidated($validated);
    }

    public function validateForUpdate(Request $request, SystemSetting $setting): SettingData
    {
        $validated = $request->validate([
            'group' => ['nullable', 'string', 'max:255'],
            'key' => ['required', 'string', 'max:255', Rule::unique('system_settings', 'key')->ignore($setting->id)],
            'value' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        return SettingData::fromValidated($validated);
    }
}
