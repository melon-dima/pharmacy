<?php

namespace Src\Modules\Pharmacies\Domain\Repositories;

use App\Models\Pharmacy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PharmacyRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator;

    public function loadForShow(Pharmacy $pharmacy): Pharmacy;

    public function codeExists(string $code, ?int $ignorePharmacyId = null): bool;

    public function hasActiveEmployees(int $pharmacyId): bool;

    public function hasFutureShifts(int $pharmacyId): bool;

    /**
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes): Pharmacy;

    /**
     * @param array<string, mixed> $attributes
     */
    public function update(Pharmacy $pharmacy, array $attributes): Pharmacy;
}
