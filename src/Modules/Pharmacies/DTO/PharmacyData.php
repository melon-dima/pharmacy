<?php

namespace Src\Modules\Pharmacies\DTO;

class PharmacyData
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $code,
        public readonly ?string $address,
        public readonly ?string $phone,
        public readonly bool $isActive,
    ) {
    }

    /**
     * @param array<string, mixed> $validated
     */
    public static function fromValidated(array $validated, bool $isActive): self
    {
        return new self(
            name: (string) $validated['name'],
            code: isset($validated['code']) ? (string) $validated['code'] : null,
            address: isset($validated['address']) ? (string) $validated['address'] : null,
            phone: isset($validated['phone']) ? (string) $validated['phone'] : null,
            isActive: $isActive,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'address' => $this->address,
            'phone' => $this->phone,
            'is_active' => $this->isActive,
        ];
    }
}
