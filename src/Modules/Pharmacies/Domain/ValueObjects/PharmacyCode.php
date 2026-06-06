<?php

namespace Src\Modules\Pharmacies\Domain\ValueObjects;

class PharmacyCode
{
    private readonly ?string $value;

    public function __construct(?string $value)
    {
        $normalized = $value === null ? null : mb_strtoupper(trim($value));

        $this->value = $normalized === '' ? null : $normalized;
    }

    public function value(): ?string
    {
        return $this->value;
    }
}
