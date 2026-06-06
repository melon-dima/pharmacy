<?php

namespace Src\Modules\Pharmacies\Services;

use App\Models\Pharmacy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\Modules\Pharmacies\Domain\Repositories\PharmacyRepositoryInterface;
use Src\Modules\Pharmacies\Domain\Services\PharmacyLifecycleService;
use Src\Modules\Pharmacies\DTO\PharmacyData;

class PharmacyService
{
    public function __construct(
        private readonly PharmacyRepositoryInterface $pharmacies,
        private readonly PharmacyLifecycleService $lifecycle,
    ) {
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->pharmacies->paginate($perPage);
    }

    public function loadForShow(Pharmacy $pharmacy): Pharmacy
    {
        return $this->pharmacies->loadForShow($pharmacy);
    }

    public function create(PharmacyData $data): Pharmacy
    {
        return $this->lifecycle->create($data);
    }

    public function update(Pharmacy $pharmacy, PharmacyData $data): Pharmacy
    {
        return $this->lifecycle->update($pharmacy, $data);
    }
}
