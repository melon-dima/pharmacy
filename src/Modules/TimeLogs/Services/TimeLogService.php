<?php

namespace Src\Modules\TimeLogs\Services;

use App\Models\Employee;
use App\Models\Shift;
use App\Models\TimeLog;
use Closure;
use Illuminate\Cache\TaggableStore;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Modules\TimeLogs\DTO\TimeLogData;

class TimeLogService
{
    private const FORM_CACHE_KEY = 'timelog.form-options.v1';
    private const FORM_CACHE_TTL = 900;

    public function paginate(int $perPage = 30): LengthAwarePaginator
    {
        return TimeLog::query()
            ->with(['employee', 'shift'])
            ->orderByDesc('logged_at')
            ->paginate($perPage);
    }

    public function loadForShow(TimeLog $timeLog): TimeLog
    {
        return $timeLog->load(['employee', 'shift']);
    }

    /**
     * @return array{employees: Collection<int, Employee>, shifts: Collection<int, Shift>}
     */
    public function getFormOptions(): array
    {
        /** @var array{employees: Collection<int, Employee>, shifts: Collection<int, Shift>} $options */
        $options = $this->rememberTagged(
            ['timelog', 'timelog:lookup'],
            self::FORM_CACHE_KEY,
            self::FORM_CACHE_TTL,
            fn (): array => [
                'employees' => Employee::query()->orderBy('full_name')->get(),
                'shifts' => Shift::query()->orderByDesc('starts_at')->get(),
            ]
        );

        return $options;
    }

    public function create(TimeLogData $data): TimeLog
    {
        $timeLog = TimeLog::query()->create($data->toArray());

        $this->flushTagged(['timelog', 'timelog:lookup']);

        return $timeLog;
    }

    public function update(TimeLog $timeLog, TimeLogData $data): TimeLog
    {
        $timeLog->update($data->toArray());

        $this->flushTagged(['timelog', 'timelog:lookup']);

        return $timeLog;
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
