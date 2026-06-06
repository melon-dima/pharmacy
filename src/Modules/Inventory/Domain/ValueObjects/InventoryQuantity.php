<?php

namespace Src\Modules\Inventory\Domain\ValueObjects;

use InvalidArgumentException;

class InventoryQuantity
{
    public function __construct(
        private readonly int $value,
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException('Количество не может быть отрицательным.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
