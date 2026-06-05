<?php

namespace Src\Modules\Settings\Actions;

use App\Models\SystemSetting;
use Src\Modules\Settings\Services\SettingService;

class ShowSettingAction
{
    public function __construct(
        private readonly SettingService $service,
    ) {
    }

    public function handle(SystemSetting $setting): SystemSetting
    {
        return $this->service->loadForShow($setting);
    }
}
