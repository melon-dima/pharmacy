<?php

namespace Src\Modules\Pharmacies\Services;

use App\Models\Pharmacy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Pharmacies\DTO\PharmacyData;

class PharmacyService
{
    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage);
    }

    public function loadForShow(Pharmacy $pharmacy): Pharmacy
    {
        return $pharmacy->load(['employees', 'shifts', 'checklists']);
    }

    public function create(PharmacyData $data): Pharmacy
    {
        return Pharmacy::query()->create($data->toArray());
    }

    public function update(Pharmacy $pharmacy, PharmacyData $data): Pharmacy
    {
        $pharmacy->update($data->toArray());

        return $pharmacy;
    }

    private function baseQuery()
    {
        return Pharmacy::query()
            ->withCount(['employees', 'shifts', 'checklists'])
            ->orderBy('name');
    }
}
