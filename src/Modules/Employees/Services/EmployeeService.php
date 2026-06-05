<?php

namespace Src\Modules\Employees\Services;

use App\Models\Employee;
use App\Models\Pharmacy;
use App\Models\User;
use Closure;
use Illuminate\Cache\TaggableStore;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Modules\Employees\DTO\EmployeeData;

class EmployeeService
{
    private const FORM_CACHE_KEY = 'employees.form-options.v1';
    private const FORM_CACHE_TTL = 900;

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return Employee::query()
            ->with(['pharmacy', 'user'])
            ->orderBy('full_name')
            ->paginate($perPage);
    }

    public function loadForShow(Employee $employee): Employee
    {
        return $employee->load(['pharmacy', 'user', 'shifts', 'timeLogs', 'requests']);
    }

    /**
     * @return array{pharmacies: Collection<int, Pharmacy>, users: Collection<int, User>}
     */
    public function getFormOptions(): array
    {
        /** @var array{pharmacies: Collection<int, Pharmacy>, users: Collection<int, User>} $options */
        $options = $this->rememberTagged(
            ['employees', 'employees:lookup'],
            self::FORM_CACHE_KEY,
            self::FORM_CACHE_TTL,
            fn (): array => [
                'pharmacies' => Pharmacy::query()->orderBy('name')->get(),
                'users' => User::query()->orderBy('name')->get(),
            ]
        );

        return $options;
    }

    public function create(EmployeeData $data): Employee
    {
        $employee = Employee::query()->create($data->toArray());

        $this->flushTagged(['employees', 'employees:lookup']);

        return $employee;
    }

    public function update(Employee $employee, EmployeeData $data): Employee
    {
        $employee->update($data->toArray());

        $this->flushTagged(['employees', 'employees:lookup']);

        return $employee;
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
