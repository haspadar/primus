<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOf;
use Primus\Decimal\MultOf;

final class MultOfTest extends TestCase
{
    #[Test]
    public function multipliesTwoPlainDecimals(): void
    {
        $this->assertSame(
            '7.50',
            (new MultOf(new DecimalOf('1.5'), new DecimalOf('5.0'), 2))->asString(),
        );
    }

    #[Test]
    public function handlesZeroFactor(): void
    {
        $this->assertSame(
            '0.00',
            (new MultOf(new DecimalOf('1.5'), new DecimalOf('0'), 2))->asString(),
        );
    }

    #[Test]
    public function handlesNegativeFactor(): void
    {
        $this->assertSame(
            '-6.0',
            (new MultOf(new DecimalOf('2.0'), new DecimalOf('-3.0'), 1))->asString(),
        );
    }

    #[Test]
    public function truncatesBeyondScale(): void
    {
        $this->assertSame(
            '0.12',
            (new MultOf(new DecimalOf('0.123'), new DecimalOf('1'), 2))->asString(),
        );
    }

    #[Test]
    public function preservesPrecisionBeyondFloat53(): void
    {
        $this->assertSame(
            '200000000000000.000002',
            (new MultOf(
                new DecimalOf('100000000000000.000001'),
                new DecimalOf('2'),
                6,
            ))->asString(),
        );
    }

    #[Test]
    public function returnsIntProjectionTruncatedTowardZero(): void
    {
        $this->assertSame(
            7,
            (new MultOf(new DecimalOf('2.5'), new DecimalOf('3.0'), 1))->asInt(),
        );
    }

    #[Test]
    public function returnsFloatProjection(): void
    {
        $this->assertSame(
            7.5,
            (new MultOf(new DecimalOf('1.5'), new DecimalOf('5.0'), 2))->asFloat(),
        );
    }

    #[Test]
    public function returnsTextProjection(): void
    {
        $this->assertSame(
            '7.50',
            (new MultOf(new DecimalOf('1.5'), new DecimalOf('5.0'), 2))->asText()->value(),
        );
    }
}
