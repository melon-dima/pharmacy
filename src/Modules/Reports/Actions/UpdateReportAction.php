<?php

namespace Src\Modules\Reports\Actions;

use App\Models\Report;
use Illuminate\Http\Request;
use Src\Modules\Reports\Services\ReportGenerationService;
use Src\Modules\Reports\Validators\UpsertReportValidator;

class UpdateReportAction
{
    public function __construct(
        private readonly UpsertReportValidator $validator,
        private readonly ReportGenerationService $service,
    ) {
    }

    public function handle(Request $request, Report $report): Report
    {
        $data = $this->validator->validate($request);

        return $this->service->update($report, $data);
    }
}
