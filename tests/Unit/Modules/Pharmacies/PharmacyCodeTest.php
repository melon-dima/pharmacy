<?php

namespace Tests\Unit\Modules\Pharmacies;

use PHPUnit\Framework\TestCase;
use Src\Modules\Pharmacies\Domain\ValueObjects\PharmacyCode;

class PharmacyCodeTest extends TestCase
{
    public function test_it_normalizes_code(): void
    {
        $code = new PharmacyCode('  apt-001  ');

        $this->assertSame('APT-001', $code->value());
    }

    public function test_empty_code_becomes_null(): void
    {
        $code = new PharmacyCode('   ');

        $this->assertNull($code->value());
    }

    public function test_null_code_stays_null(): void
    {
        $code = new PharmacyCode(null);

        $this->assertNull($code->value());
    }
}
