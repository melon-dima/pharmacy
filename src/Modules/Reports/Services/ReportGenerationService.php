<?php

namespace Src\Modules\Reports\Services;

use App\Jobs\GenerateReportJob;
use App\Models\Report;
use App\Models\User;
use Closure;
use Illuminate\Cache\TaggableStore;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Modules\Reports\DTO\ReportData;
use Src\Modules\Reports\DTO\QueueReportData;

class ReportGenerationService
{
    private const FORM_CACHE_KEY = 'reports.form-options.v1';
    private const FORM_CACHE_TTL = 900;

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return Report::query()
            ->with('generatedByUser')
            ->orderByDesc('generated_at')
            ->paginate($perPage);
    }

    public function loadForShow(Report $report): Report
    {
        return $report->load('generatedByUser');
    }

    /**
     * @return Collection<int, User>
     */
    public function getFormUsers(): Collection
    {
        /** @var Collection<int, User> $users */
        $users = $this->rememberTagged(
            ['reports', 'reports:lookup'],
            self::FORM_CACHE_KEY,
            self::FORM_CACHE_TTL,
            fn (): Collection => User::query()->orderBy('name')->get()
        );

        return $users;
    }

    public function queueReport(QueueReportData $data): Report
    {
        $report = Report::query()->create([
            'name' => $data->name,
            'type' => $data->type,
            'period_start' => $data->periodStart,
            'period_end' => $data->periodEnd,
            'generated_by_user_id' => $data->generatedByUserId,
            'generated_at' => null,
            'payload' => [
                'status' => 'queued',
            ],
        ]);

        GenerateReportJob::dispatch($report->id);

        $this->flushTagged(['reports', 'reports:lookup']);

        return $report;
    }

    public function update(Report $report, ReportData $data): Report
    {
        $report->update($data->toArray());

        $this->flushTagged(['reports', 'reports:lookup']);

        return $report;
    }

    /**
     * @template T
     *
     * @param array<int, string> $tags
     * @param Closure(): T $callback
     *
     * @return T
     */
    private function rememberTagged(array $tags, string $key, int $seconds, Closure $callback): mixed
    {
        if (Cache::getStore() instanceof TaggableStore) {
            return Cache::tags($tags)->remember($key, $seconds, $callback);
        }

        return Cache::remember($key, $seconds, $callback);
    }

    /**
     * @param array<int, string> $tags
     */
    private function flushTagged(array $tags): void
    {
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags($tags)->flush();
        }
    }
}
