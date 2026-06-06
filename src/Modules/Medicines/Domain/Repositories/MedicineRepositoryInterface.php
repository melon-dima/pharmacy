<?php

namespace Src\Modules\Medicines\Domain\Repositories;

use App\Models\Medicine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MedicineRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator;

    public function loadForShow(Medicine $medicine): Medicine;

    public function skuExists(string $sku, ?int $ignoreMedicineId = null): bool;

    public function externalIdentityExists(string $system, string $externalId, ?int $ignoreMedicineId = null): bool;

    /**
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes): Medicine;

    /**
     * @param array<string, mixed> $attributes
     */
    public function update(Medicine $medicine, array $attributes): Medicine;

    public function deactivate(Medicine $medicine): Medicine;
}
