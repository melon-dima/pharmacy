<?php

namespace Src\Modules\Pharmacies\Domain\Services;

use App\Models\Pharmacy;
use Src\Modules\Pharmacies\Domain\Exceptions\CannotDeactivatePharmacy;
use Src\Modules\Pharmacies\Domain\Exceptions\DuplicatePharmacyCode;
use Src\Modules\Pharmacies\Domain\Repositories\PharmacyRepositoryInterface;
use Src\Modules\Pharmacies\Domain\ValueObjects\PharmacyCode;
use Src\Modules\Pharmacies\DTO\PharmacyData;

class PharmacyLifecycleService
{
    public function __construct(
        private readonly PharmacyRepositoryInterface $pharmacies,
    ) {
    }

    public function create(PharmacyData $data): Pharmacy
    {
        $payload = $this->normalizePayload($data);
        $this->ensureCodeIsUnique($payload['code']);

        return $this->pharmacies->create($payload);
    }

    public function update(Pharmacy $pharmacy, PharmacyData $data): Pharmacy
    {
        $payload = $this->normalizePayload($data);
        $this->ensureCodeIsUnique($payload['code'], $pharmacy->id);

        if ($pharmacy->is_active && ! $data->isActive) {
            $this->ensureCanBeDeactivated($pharmacy);
        }

        return $this->pharmacies->update($pharmacy, $payload);
    }

    /**
     * @return array<string, mixed>
     */
    private function normalizePayload(PharmacyData $data): array
    {
        $payload = $data->toArray();
        $payload['code'] = (new PharmacyCode($data->code))->value();

        return $payload;
    }

    private function ensureCodeIsUnique(?string $code, ?int $ignorePharmacyId = null): void
    {
        if ($code === null) {
            return;
        }

        if ($this->pharmacies->codeExists($code, $ignorePharmacyId)) {
            throw new DuplicatePharmacyCode('Аптека с таким кодом уже существует.');
        }
    }

    private function ensureCanBeDeactivated(Pharmacy $pharmacy): void
    {
        if ($this->pharmacies->hasActiveEmployees($pharmacy->id)) {
            throw new CannotDeactivatePharmacy('Нельзя деактивировать аптеку с активными сотрудниками.');
        }

        if ($this->pharmacies->hasFutureShifts($pharmacy->id)) {
            throw new CannotDeactivatePharmacy('Нельзя деактивировать аптеку с будущими сменами.');
        }
    }
}
