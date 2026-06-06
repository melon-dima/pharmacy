<?php

namespace Src\Modules\Analytics\Infrastructure\ClickHouse;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Src\Modules\Analytics\Domain\AnalyticsEventRecorderInterface;
use Src\Modules\Analytics\DTO\AnalyticsEventData;
use Throwable;

class ClickHouseAnalyticsEventRecorder implements AnalyticsEventRecorderInterface
{
    public function record(AnalyticsEventData $event): void
    {
        try {
            Http::withBasicAuth(
                (string) config('services.clickhouse.username'),
                (string) config('services.clickhouse.password'),
            )
                ->timeout((int) config('services.clickhouse.timeout', 2))
                ->withBody(
                    json_encode($event->toClickHouseRow(), JSON_THROW_ON_ERROR).PHP_EOL,
                    'application/x-ndjson',
                )
                ->post($this->endpoint());
        } catch (Throwable $exception) {
            Log::warning('ClickHouse analytics event recording failed.', [
                'event_name' => $event->eventName,
                'subject_type' => $event->subjectType,
                'subject_id' => $event->subjectId,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    private function endpoint(): string
    {
        return rtrim((string) config('services.clickhouse.url'), '/')
            .'?'.http_build_query([
                'database' => config('services.clickhouse.database'),
                'query' => 'INSERT INTO analytics_events FORMAT JSONEachRow',
            ]);
    }
}
