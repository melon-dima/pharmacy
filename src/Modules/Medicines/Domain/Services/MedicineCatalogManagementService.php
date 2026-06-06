<?php

namespace Src\Modules\Medicines\Domain\Services;

use App\Models\Medicine;
use Src\Modules\Medicines\Domain\Exceptions\DuplicateMedicineExternalIdentity;
use Src\Modules\Medicines\Domain\Exceptions\DuplicateMedicineSku;
use Src\Modules\Medicines\Domain\Repositories\MedicineRepositoryInterface;
use Src\Modules\Medicines\Domain\Search\MedicineSearchIndexerInterface;
use Src\Modules\Medicines\Domain\ValueObjects\MedicineExternalIdentity;
use Src\Modules\Medicines\Domain\ValueObjects\MedicinePrice;
use Src\Modules\Medicines\Domain\ValueObjects\MedicineSku;
use Src\Modules\Medicines\DTO\MedicineData;

class MedicineCatalogManagementService
{
    public function __construct(
        private readonly MedicineRepositoryInterface $medicines,
        private readonly MedicineSearchIndexerInterface $searchIndexer,
    ) {
    }

    public function create(MedicineData $data): Medicine
    {
        $payload = $this->normalizePayload($data);
        $this->ensureSkuIsUnique($payload['sku']);
        $this->ensureExternalIdentityIsUnique($payload['external_system'], $payload['external_id']);

        $medicine = $this->medicines->create($payload);
        $this->searchIndexer->index($medicine);

        return $medicine;
    }

    public function update(Medicine $medicine, MedicineData $data): Medicine
    {
        $payload = $this->normalizePayload($data);
        $this->ensureSkuIsUnique($payload['sku'], $medicine->id);
        $this->ensureExternalIdentityIsUnique($payload['external_system'], $payload['external_id'], $medicine->id);

        $medicine = $this->medicines->update($medicine, $payload);
        $this->searchIndexer->index($medicine);

        return $medicine;
    }

    public function deactivate(Medicine $medicine): Medicine
    {
        $medicine = $this->medicines->deactivate($medicine);
        $this->searchIndexer->remove($medicine);

        return $medicine;
    }

    /**
     * @return array<string, mixed>
     */
    private function normalizePayload(MedicineData $data): array
    {
        $payload = $data->toArray();
        $externalIdentity = new MedicineExternalIdentity($data->externalSystem, $data->externalId);

        $payload['name'] = trim($data->name);
        $payload['sku'] = (new MedicineSku($data->sku))->value();
        $payload['manufacturer'] = $data->manufacturer === null ? null : trim($data->manufacturer);
        $payload['description'] = $data->description === null ? null : trim($data->description);
        $payload['dosage_form'] = $data->dosageForm === null ? null : trim($data->dosageForm);
        $payload['unit'] = trim($data->unit);
        $payload['price_cents'] = (new MedicinePrice($data->priceCents))->cents();
        $payload['currency'] = strtoupper(trim($data->currency));
        $payload['external_system'] = $externalIdentity->system();
        $payload['external_id'] = $externalIdentity->externalId();

        return $payload;
    }

    private function ensureSkuIsUnique(?string $sku, ?int $ignoreMedicineId = null): void
    {
        if ($sku === null) {
            return;
        }

        if ($this->medicines->skuExists($sku, $ignoreMedicineId)) {
            throw new DuplicateMedicineSku('Лекарство с таким кодом уже существует.');
        }
    }

    private function ensureExternalIdentityIsUnique(?string $system, ?string $externalId, ?int $ignoreMedicineId = null): void
    {
        if ($system === null || $externalId === null) {
            return;
        }

        if ($this->medicines->externalIdentityExists($system, $externalId, $ignoreMedicineId)) {
            throw new DuplicateMedicineExternalIdentity('Лекарство с таким внешним идентификатором уже связано с каталогом.');
        }
    }
}
