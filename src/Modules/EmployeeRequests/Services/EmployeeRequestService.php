<?php

namespace Src\Modules\EmployeeRequests\Services;

use App\Models\Employee;
use App\Models\EmployeeRequest;
use App\Models\User;
use Closure;
use Illuminate\Cache\TaggableStore;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Src\Modules\EmployeeRequests\DTO\EmployeeRequestData;

class EmployeeRequestService
{
    private const FORM_CACHE_KEY = 'employee-requests.form-options.v1';
    private const FORM_CACHE_TTL = 900;

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return EmployeeRequest::query()
            ->with(['employee', 'approvedByUser'])
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function loadForShow(EmployeeRequest $employeeRequest): EmployeeRequest
    {
        return $employeeRequest->load(['employee', 'approvedByUser']);
    }

    /**
     * @return array{employees: Collection<int, Employee>, users: Collection<int, User>}
     */
    public function getFormOptions(): array
    {
        /** @var array{employees: Collection<int, Employee>, users: Collection<int, User>} $options */
        $options = $this->rememberTagged(
            ['employee-requests', 'employee-requests:lookup'],
            self::FORM_CACHE_KEY,
            self::FORM_CACHE_TTL,
            fn (): array => [
                'employees' => Employee::query()->orderBy('full_name')->get(),
                'users' => User::query()->orderBy('name')->get(),
            ]
        );

        return $options;
    }

    public function create(EmployeeRequestData $data): EmployeeRequest
    {
        $employeeRequest = EmployeeRequest::query()->create($data->toArray());

        $this->flushTagged(['employee-requests', 'employee-requests:lookup']);

        return $employeeRequest;
    }

    public function update(EmployeeRequest $employeeRequest, EmployeeRequestData $data): EmployeeRequest
    {
        $employeeRequest->update($data->toArray());

        $this->flushTagged(['employee-requests', 'employee-requests:lookup']);

        return $employeeRequest;
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
