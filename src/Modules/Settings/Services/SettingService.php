<?php

namespace Src\Modules\Settings\Services;

use App\Models\SystemSetting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Settings\DTO\SettingData;

class SettingService
{
    public function paginate(int $perPage = 30): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage);
    }

    public function loadForShow(SystemSetting $setting): SystemSetting
    {
        return $setting;
    }

    public function create(SettingData $data): SystemSetting
    {
        return SystemSetting::query()->create($data->toArray());
    }

    public function update(SystemSetting $setting, SettingData $data): SystemSetting
    {
        $setting->update($data->toArray());

        return $setting;
    }

    private function baseQuery()
    {
        return SystemSetting::query()
            ->orderBy('group')
            ->orderBy('key');
    }
}
