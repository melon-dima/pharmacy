<?php

namespace Src\Modules\Pharmacies\Infrastructure\Repositories;

use App\Models\Employee;
use App\Models\Pharmacy;
use App\Models\Shift;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Src\Modules\Pharmacies\Domain\Repositories\PharmacyRepositoryInterface;

class EloquentPharmacyRepository implements PharmacyRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Pharmacy::query()
            ->withCount(['employees', 'shifts', 'checklists', 'inventoryItems'])
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function loadForShow(Pharmacy $pharmacy): Pharmacy
    {
        return $pharmacy->load(['employees', 'shifts', 'checklists', 'inventoryItems.medicine']);
    }

    public function codeExists(string $code, ?int $ignorePharmacyId = null): bool
    {
        return Pharmacy::query()
            ->where('code', $code)
            ->when($ignorePharmacyId !== null, fn ($query) => $query->whereKeyNot($ignorePharmacyId))
            ->exists();
    }

    public function hasActiveEmployees(int $pharmacyId): bool
    {
        return Employee::query()
            ->where('pharmacy_id', $pharmacyId)
            ->where('is_active', true)
            ->exists();
    }

    public function hasFutureShifts(int $pharmacyId): bool
    {
        return Shift::query()
            ->where('pharmacy_id', $pharmacyId)
            ->where('starts_at', '>=', Carbon::now())
            ->exists();
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes): Pharmacy
    {
        return Pharmacy::query()->create($attributes);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function update(Pharmacy $pharmacy, array $attributes): Pharmacy
    {
        $pharmacy->update($attributes);

        return $pharmacy;
    }
}
