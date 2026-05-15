<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOfFloat;

final class DecimalOfFloatTest extends TestCase
{
    #[Test]
    public function rendersShortDecimalExactly(): void
    {
        $this->assertSame('0.3', (new DecimalOfFloat(0.3))->asText()->value());
    }

    #[Test]
    public function rendersIntegerValuedFloatWithoutDecimalPoint(): void
    {
        $this->assertSame('42', (new DecimalOfFloat(42.0))->asText()->value());
    }

    #[Test]
    public function rendersNegativeFloat(): void
    {
        $this->assertSame('-3.14', (new DecimalOfFloat(-3.14))->asText()->value());
    }

    #[Test]
    public function truncatesIntProjectionTowardZero(): void
    {
        $this->assertSame(3, (new DecimalOfFloat(3.99))->asInt());
    }

    #[Test]
    public function returnsFloatProjection(): void
    {
        $this->assertSame(3.14, (new DecimalOfFloat(3.14))->asFloat());
    }
}
