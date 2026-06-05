<?php

namespace Src\Modules\Reports\Actions;

use App\Models\Report;
use Src\Modules\Reports\Services\ReportGenerationService;

class ShowReportAction
{
    public function __construct(
        private readonly ReportGenerationService $service,
    ) {
    }

    public function handle(Report $report): Report
    {
        return $this->service->loadForShow($report);
    }
}
