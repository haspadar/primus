<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOf;

final class DecimalOfTest extends TestCase
{
    #[Test]
    public function keepsPlainDecimalAsIs(): void
    {
        $this->assertSame('3.14', (new DecimalOf('3.14'))->asText()->value());
    }

    #[Test]
    public function preservesPrecisionBeyondFloat53(): void
    {
        $this->assertSame(
            '100000000000000.000001',
            (new DecimalOf('100000000000000.000001'))->asText()->value(),
        );
    }

    #[Test]
    public function keepsNegativeAsIs(): void
    {
        $this->assertSame('-7.5', (new DecimalOf('-7.5'))->asText()->value());
    }

    #[Test]
    public function truncatesIntProjectionTowardZero(): void
    {
        $this->assertSame(3, (new DecimalOf('3.99'))->asInt());
    }

    #[Test]
    public function truncatesNegativeIntProjectionTowardZero(): void
    {
        $this->assertSame(-3, (new DecimalOf('-3.99'))->asInt());
    }

    #[Test]
    public function returnsFloatProjection(): void
    {
        $this->assertSame(3.14, (new DecimalOf('3.14'))->asFloat());
    }
}
