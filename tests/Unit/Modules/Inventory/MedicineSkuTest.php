<?php

namespace Tests\Unit\Modules\Inventory;

use PHPUnit\Framework\TestCase;
use Src\Modules\Inventory\Domain\ValueObjects\MedicineSku;

class MedicineSkuTest extends TestCase
{
    public function test_it_normalizes_sku(): void
    {
        $sku = new MedicineSku(' med-001 ');

        $this->assertSame('MED-001', $sku->value());
    }

    public function test_empty_sku_becomes_null(): void
    {
        $sku = new MedicineSku('   ');

        $this->assertNull($sku->value());
    }
}
