<?php

namespace Src\Modules\Reports\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Src\Modules\Reports\Services\ReportGenerationService;

class GetReportFormOptionsAction
{
    public function __construct(
        private readonly ReportGenerationService $service,
    ) {
    }

    /**
     * @return Collection<int, User>
     */
    public function handle(): Collection
    {
        return $this->service->getFormUsers();
    }
}
