<?php

namespace Src\Modules\Medicines\Infrastructure\Search;

use App\Models\Medicine;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Src\Modules\Medicines\Domain\Search\MedicineSearchIndexerInterface;
use Throwable;

class ElasticsearchMedicineSearchIndexer implements MedicineSearchIndexerInterface
{
    public function index(Medicine $medicine): void
    {
        try {
            Http::timeout((int) config('services.elasticsearch.timeout', 2))
                ->put($this->endpoint((string) $medicine->id), [
                    'id' => $medicine->id,
                    'name' => $medicine->name,
                    'sku' => $medicine->sku,
                    'manufacturer' => $medicine->manufacturer,
                    'description' => $medicine->description,
                    'dosage_form' => $medicine->dosage_form,
                    'unit' => $medicine->unit,
                    'price_cents' => $medicine->price_cents,
                    'currency' => $medicine->currency,
                    'is_active' => $medicine->is_active,
                    'external_system' => $medicine->external_system,
                    'external_id' => $medicine->external_id,
                    'updated_at' => $medicine->updated_at?->toISOString(),
                ]);
        } catch (Throwable $exception) {
            Log::warning('Elasticsearch medicine indexing failed.', [
                'medicine_id' => $medicine->id,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function remove(Medicine $medicine): void
    {
        try {
            Http::timeout((int) config('services.elasticsearch.timeout', 2))
                ->delete($this->endpoint((string) $medicine->id));
        } catch (Throwable $exception) {
            Log::warning('Elasticsearch medicine removal failed.', [
                'medicine_id' => $medicine->id,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    private function endpoint(string $path): string
    {
        return rtrim((string) config('services.elasticsearch.url'), '/')
            .'/'.trim((string) config('services.elasticsearch.medicine_index'), '/')
            .'/_doc/'.ltrim($path, '/');
    }
}
