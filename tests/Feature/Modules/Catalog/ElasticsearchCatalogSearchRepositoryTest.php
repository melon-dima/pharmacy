<?php

namespace Tests\Feature\Modules\Catalog;

use Illuminate\Support\Facades\Http;
use Src\Modules\Catalog\Infrastructure\Search\ElasticsearchCatalogSearchRepository;
use Tests\TestCase;

class ElasticsearchCatalogSearchRepositoryTest extends TestCase
{
    public function test_it_returns_medicine_ids_from_elasticsearch_hits(): void
    {
        config()->set('services.elasticsearch.url', 'http://elasticsearch:9200');
        config()->set('services.elasticsearch.medicine_index', 'medicines');
        Http::fake([
            'http://elasticsearch:9200/medicines/_search' => Http::response([
                'hits' => [
                    'hits' => [
                        ['_id' => '15'],
                        ['_id' => '20'],
                    ],
                ],
            ], 200),
        ]);

        $repository = new ElasticsearchCatalogSearchRepository();

        $this->assertSame([15, 20], $repository->searchMedicineIds('aspirin'));
        Http::assertSent(fn ($request): bool => $request->method() === 'POST'
            && $request->url() === 'http://elasticsearch:9200/medicines/_search'
            && $request->data()['query']['bool']['must'][0]['multi_match']['query'] === 'aspirin');
    }

    public function test_it_returns_null_when_elasticsearch_is_unavailable(): void
    {
        config()->set('services.elasticsearch.url', 'http://elasticsearch:9200');
        config()->set('services.elasticsearch.medicine_index', 'medicines');
        Http::fake([
            'http://elasticsearch:9200/medicines/_search' => Http::response([], 503),
        ]);

        $repository = new ElasticsearchCatalogSearchRepository();

        $this->assertNull($repository->searchMedicineIds('aspirin'));
    }
}
