<?php

namespace Src\Modules\CustomerOrders\Domain\ValueObjects;

use InvalidArgumentException;

class OrderQuantity
{
    public function __construct(
        private readonly int $value,
    ) {
        if ($value < 1) {
            throw new InvalidArgumentException('Количество в заказе должно быть больше нуля.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
