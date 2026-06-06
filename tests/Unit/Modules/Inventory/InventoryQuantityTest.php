<?php

namespace Tests\Unit\Modules\Inventory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Src\Modules\Inventory\Domain\ValueObjects\InventoryQuantity;

class InventoryQuantityTest extends TestCase
{
    public function test_quantity_can_be_zero(): void
    {
        $quantity = new InventoryQuantity(0);

        $this->assertSame(0, $quantity->value());
    }

    public function test_quantity_cannot_be_negative(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new InventoryQuantity(-1);
    }
}
