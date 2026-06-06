<?php

namespace Src\Modules\Inventory\Domain\ValueObjects;

class MedicineSku
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
