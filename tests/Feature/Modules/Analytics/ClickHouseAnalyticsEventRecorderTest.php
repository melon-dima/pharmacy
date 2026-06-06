<?php

namespace Tests\Feature\Modules\Analytics;

use Illuminate\Support\Facades\Http;
use Src\Modules\Analytics\DTO\AnalyticsEventData;
use Src\Modules\Analytics\Infrastructure\ClickHouse\ClickHouseAnalyticsEventRecorder;
use Tests\TestCase;

class ClickHouseAnalyticsEventRecorderTest extends TestCase
{
    public function test_it_sends_analytics_event_to_clickhouse(): void
    {
        config()->set('services.clickhouse.url', 'http://clickhouse:8123');
        config()->set('services.clickhouse.database', 'pharmacy');
        config()->set('services.clickhouse.username', 'pharmacy');
        config()->set('services.clickhouse.password', 'pharmacy');
        Http::fake([
            'http://clickhouse:8123*' => Http::response('', 200),
        ]);

        $recorder = new ClickHouseAnalyticsEventRecorder();
        $recorder->record(new AnalyticsEventData(
            eventName: 'customer_order_created',
            actorId: 10,
            subjectType: 'customer_order',
            subjectId: 20,
            payload: ['total_cents' => 1500],
        ));

        Http::assertSent(function ($request): bool {
            return $request->method() === 'POST'
                && str_contains($request->url(), 'INSERT+INTO+analytics_events')
                && str_contains($request->body(), '"event_name":"customer_order_created"')
                && str_contains($request->body(), '"subject_id":20');
        });
    }
}
