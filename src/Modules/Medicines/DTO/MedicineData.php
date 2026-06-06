<?php

namespace Src\Modules\Medicines\DTO;

class MedicineData
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $sku,
        public readonly ?string $manufacturer,
        public readonly ?string $description,
        public readonly ?string $dosageForm,
        public readonly string $unit,
        public readonly int $priceCents,
        public readonly string $currency,
        public readonly bool $isActive,
        public readonly ?string $externalSystem,
        public readonly ?string $externalId,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated, bool $isActive): self
    {
        return new self(
            name: (string) $validated['name'],
            sku: isset($validated['sku']) ? (string) $validated['sku'] : null,
            manufacturer: isset($validated['manufacturer']) ? (string) $validated['manufacturer'] : null,
            description: isset($validated['description']) ? (string) $validated['description'] : null,
            dosageForm: isset($validated['dosage_form']) ? (string) $validated['dosage_form'] : null,
            unit: (string) $validated['unit'],
            priceCents: self::priceToCents((string) ($validated['price'] ?? '0')),
            currency: (string) ($validated['currency'] ?? 'RUB'),
            isActive: $isActive,
            externalSystem: isset($validated['external_system']) ? (string) $validated['external_system'] : null,
            externalId: isset($validated['external_id']) ? (string) $validated['external_id'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'manufacturer' => $this->manufacturer,
            'description' => $this->description,
            'dosage_form' => $this->dosageForm,
            'unit' => $this->unit,
            'price_cents' => $this->priceCents,
            'currency' => $this->currency,
            'is_active' => $this->isActive,
            'external_system' => $this->externalSystem,
            'external_id' => $this->externalId,
        ];
    }

    private static function priceToCents(string $price): int
    {
        $normalized = str_replace(',', '.', trim($price));
        $parts = explode('.', $normalized, 2);
        $rubles = (int) ($parts[0] === '' ? 0 : $parts[0]);
        $kopecks = isset($parts[1]) ? (int) str_pad(substr($parts[1], 0, 2), 2, '0') : 0;

        return ($rubles * 100) + $kopecks;
    }
}
