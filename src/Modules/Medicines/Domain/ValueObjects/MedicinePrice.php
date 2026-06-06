<?php

namespace Src\Modules\Medicines\Domain\ValueObjects;

use InvalidArgumentException;

class MedicinePrice
{
    public function __construct(
        private readonly int $cents,
    ) {
        if ($cents < 0) {
            throw new InvalidArgumentException('Цена лекарства не может быть отрицательной.');
        }
    }

    public function cents(): int
    {
        return $this->cents;
    }
}
