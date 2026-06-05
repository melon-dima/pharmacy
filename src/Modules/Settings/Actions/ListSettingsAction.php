<?php

namespace Src\Modules\Settings\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Settings\Services\SettingService;

class ListSettingsAction
{
    public function __construct(
        private readonly SettingService $service,
    ) {
    }

    public function handle(int $perPage = 30): LengthAwarePaginator
    {
        return $this->service->paginate($perPage);
    }
}
