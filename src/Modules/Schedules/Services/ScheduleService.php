<?php

namespace Src\Modules\Schedules\Services;

use App\Models\Employee;
use App\Models\Pharmacy;
use App\Models\Shift;
use Closure;
use Illuminate\Cache\TaggableStore;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Modules\Schedules\DTO\ScheduleData;

class ScheduleService
{
    private const FORM_CACHE_KEY = 'schedules.form-options.v2';
    private const FORM_CACHE_TTL = 900;

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return Shift::query()
            ->with(['employee', 'pharmacy'])
            ->orderByDesc('starts_at')
            ->paginate($perPage);
    }

    public function loadForShow(Shift $shift): Shift
    {
        return $shift->load(['employee', 'pharmacy', 'timeLogs']);
    }

    /**
     * @return array{employees: Collection<int, Employee>, pharmacies: Collection<int, Pharmacy>}
     */
    public function getFormOptions(): array
    {
        /** @var array{employees: Collection<int, Employee>, pharmacies: Collection<int, Pharmacy>} $options */
        $options = $this->rememberTagged(
            ['schedules', 'schedules:lookup'],
            self::FORM_CACHE_KEY,
            self::FORM_CACHE_TTL,
            fn (): array => $this->fetchFormOptions()
        );

        if (! $this->isValidFormOptions($options)) {
            $options = $this->fetchFormOptions();
            $this->putTagged(['schedules', 'schedules:lookup'], self::FORM_CACHE_KEY, self::FORM_CACHE_TTL, $options);
        }

        return $options;
    }

    public function create(ScheduleData $data): Shift
    {
        $shift = Shift::query()->create($data->toArray());

        $this->flushTagged(['schedules', 'schedules:lookup']);

        return $shift;
    }

    public function update(Shift $shift, ScheduleData $data): Shift
    {
        $shift->update($data->toArray());

        $this->flushTagged(['schedules', 'schedules:lookup']);

        return $shift;
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

    /**
     * @return array{employees: Collection<int, Employee>, pharmacies: Collection<int, Pharmacy>}
     */
    private function fetchFormOptions(): array
    {
        return [
            'employees' => Employee::query()->orderBy('full_name')->get(),
            'pharmacies' => Pharmacy::query()->orderBy('name')->get(),
        ];
    }

    /**
     * @param array<string, mixed> $options
     */
    private function isValidFormOptions(array $options): bool
    {
        if (
            ! isset($options['employees'], $options['pharmacies']) ||
            ! $options['employees'] instanceof Collection ||
            ! $options['pharmacies'] instanceof Collection
        ) {
            return false;
        }

        $firstEmployee = $options['employees']->first();
        $firstPharmacy = $options['pharmacies']->first();

        $isEmployeeValid = $firstEmployee === null || $firstEmployee instanceof Employee;
        $isPharmacyValid = $firstPharmacy === null || $firstPharmacy instanceof Pharmacy;

        return $isEmployeeValid && $isPharmacyValid;
    }

    /**
     * @param array<int, string> $tags
     * @param array<string, mixed> $value
     */
    private function putTagged(array $tags, string $key, int $seconds, array $value): void
    {
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags($tags)->put($key, $value, $seconds);

            return;
        }

        Cache::put($key, $value, $seconds);
    }
}
