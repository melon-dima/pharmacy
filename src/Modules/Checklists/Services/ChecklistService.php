<?php

namespace Src\Modules\Checklists\Services;

use App\Models\Checklist;
use App\Models\Pharmacy;
use Closure;
use Illuminate\Cache\TaggableStore;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Modules\Checklists\DTO\ChecklistData;

class ChecklistService
{
    private const FORM_CACHE_KEY = 'checklists.form-options.v1';
    private const FORM_CACHE_TTL = 900;

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return Checklist::query()
            ->with('pharmacy')
            ->withCount(['items', 'submissions'])
            ->orderBy('title')
            ->paginate($perPage);
    }

    public function loadForShow(Checklist $checklist): Checklist
    {
        return $checklist->load(['pharmacy', 'items', 'submissions']);
    }

    /**
     * @return Collection<int, Pharmacy>
     */
    public function getFormPharmacies(): Collection
    {
        /** @var Collection<int, Pharmacy> $items */
        $items = $this->rememberTagged(
            ['checklists', 'checklists:lookup'],
            self::FORM_CACHE_KEY,
            self::FORM_CACHE_TTL,
            fn (): Collection => Pharmacy::query()->orderBy('name')->get()
        );

        return $items;
    }

    public function create(ChecklistData $data): Checklist
    {
        $checklist = Checklist::query()->create($data->toArray());

        $this->flushTagged(['checklists', 'checklists:lookup']);

        return $checklist;
    }

    public function update(Checklist $checklist, ChecklistData $data): Checklist
    {
        $checklist->update($data->toArray());

        $this->flushTagged(['checklists', 'checklists:lookup']);

        return $checklist;
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
