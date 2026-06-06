<?php

namespace Src\Modules\Catalog\Infrastructure\Search;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Src\Modules\Catalog\Domain\Repositories\CatalogSearchRepositoryInterface;
use Throwable;

class ElasticsearchCatalogSearchRepository implements CatalogSearchRepositoryInterface
{
    public function searchMedicineIds(string $query, int $limit = 100): ?array
    {
        try {
            $response = Http::timeout((int) config('services.elasticsearch.timeout', 2))
                ->post($this->endpoint('_search'), [
                    'size' => $limit,
                    '_source' => false,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => ['is_active' => true]],
                            ],
                            'must' => [
                                [
                                    'multi_match' => [
                                        'query' => $query,
                                        'fields' => [
                                            'name^4',
                                            'sku^3',
                                            'manufacturer^2',
                                            'description',
                                            'dosage_form',
                                        ],
                                        'fuzziness' => 'AUTO',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]);

            if (! $response->successful()) {
                return null;
            }

            return collect($response->json('hits.hits', []))
                ->pluck('_id')
                ->map(fn (mixed $id): int => (int) $id)
                ->filter(fn (int $id): bool => $id > 0)
                ->values()
                ->all();
        } catch (Throwable $exception) {
            Log::warning('Elasticsearch medicine search failed.', [
                'query' => $query,
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    private function endpoint(string $path): string
    {
        return rtrim((string) config('services.elasticsearch.url'), '/')
            .'/'.trim((string) config('services.elasticsearch.medicine_index'), '/')
            .'/'.ltrim($path, '/');
    }
}
