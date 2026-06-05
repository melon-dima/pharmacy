<?php

namespace Src\Modules\Settings\Actions;

use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Src\Modules\Settings\Services\SettingService;
use Src\Modules\Settings\Validators\UpsertSettingValidator;

class CreateSettingAction
{
    public function __construct(
        private readonly UpsertSettingValidator $validator,
        private readonly SettingService $service,
    ) {
    }

    public function handle(Request $request): SystemSetting
    {
        $data = $this->validator->validateForCreate($request);

        return $this->service->create($data);
    }
}
