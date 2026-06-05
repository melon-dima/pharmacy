<?php

namespace Src\Modules\Reports\Actions;

use App\Models\Report;
use Illuminate\Http\Request;
use Src\Modules\Reports\Services\ReportGenerationService;
use Src\Modules\Reports\Validators\QueueReportValidator;

class QueueReportGenerationAction
{
    public function __construct(
        private readonly QueueReportValidator $validator,
        private readonly ReportGenerationService $reportGenerationService,
    ) {
    }

    public function handle(Request $request): Report
    {
        $data = $this->validator->validate($request);

        return $this->reportGenerationService->queueReport($data);
    }
}
