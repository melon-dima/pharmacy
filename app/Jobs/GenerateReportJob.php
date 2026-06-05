<?php

namespace App\Jobs;

use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateReportJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $reportId,
    ) {
    }

    public function handle(): void
    {
        $report = Report::query()->find($this->reportId);

        if ($report === null) {
            return;
        }

        $payload = (array) ($report->payload ?? []);
        $payload['status'] = 'done';
        $payload['generated_by_job'] = true;

        $report->update([
            'payload' => $payload,
            'generated_at' => now(),
        ]);
    }
}
