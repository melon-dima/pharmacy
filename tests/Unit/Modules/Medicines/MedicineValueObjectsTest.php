<?php

namespace Tests\Unit\Modules\Medicines;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Src\Modules\Medicines\Domain\ValueObjects\MedicineExternalIdentity;
use Src\Modules\Medicines\Domain\ValueObjects\MedicinePrice;
use Src\Modules\Medicines\Domain\ValueObjects\MedicineSku;

class MedicineValueObjectsTest extends TestCase
{
    public function test_sku_is_normalized(): void
    {
        $sku = new MedicineSku(' med-001 ');

        $this->assertSame('MED-001', $sku->value());
    }

    public function test_price_cannot_be_negative(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new MedicinePrice(-1);
    }

    public function test_external_identity_requires_complete_pair(): void
    {
        $identity = new MedicineExternalIdentity('1c', null);

        $this->assertNull($identity->system());
        $this->assertNull($identity->externalId());
    }
}
