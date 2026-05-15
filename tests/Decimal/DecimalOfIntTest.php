<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOfInt;

final class DecimalOfIntTest extends TestCase
{
    #[Test]
    public function rendersPositiveIntAsText(): void
    {
        $this->assertSame('42', (new DecimalOfInt(42))->asText()->value());
    }

    #[Test]
    public function rendersNegativeIntAsText(): void
    {
        $this->assertSame('-7', (new DecimalOfInt(-7))->asText()->value());
    }

    #[Test]
    public function rendersZeroAsText(): void
    {
        $this->assertSame('0', (new DecimalOfInt(0))->asText()->value());
    }

    #[Test]
    public function returnsIntProjection(): void
    {
        $this->assertSame(42, (new DecimalOfInt(42))->asInt());
    }

    #[Test]
    public function returnsFloatProjection(): void
    {
        $this->assertSame(42.0, (new DecimalOfInt(42))->asFloat());
    }

    #[Test]
    public function preservesPrecisionBeyondFloat53InText(): void
    {
        $this->assertSame('9007199254740993', (new DecimalOfInt(9007199254740993))->asText()->value());
    }
}
