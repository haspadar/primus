<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOf;
use Primus\Decimal\SumOf;

final class SumOfTest extends TestCase
{
    #[Test]
    public function addsTwoPlainDecimals(): void
    {
        $this->assertSame(
            '4.0',
            (new SumOf(new DecimalOf('1.5'), new DecimalOf('2.5'), 1))->asString(),
        );
    }

    #[Test]
    public function keepsExactFractionalSum(): void
    {
        $this->assertSame(
            '0.3',
            (new SumOf(new DecimalOf('0.1'), new DecimalOf('0.2'), 1))->asString(),
        );
    }

    #[Test]
    public function handlesNegativeAddend(): void
    {
        $this->assertSame(
            '-1.0',
            (new SumOf(new DecimalOf('2.0'), new DecimalOf('-3.0'), 1))->asString(),
        );
    }

    #[Test]
    public function truncatesBeyondScale(): void
    {
        $this->assertSame(
            '0.12',
            (new SumOf(new DecimalOf('0.123'), new DecimalOf('0.001'), 2))->asString(),
        );
    }

    #[Test]
    public function preservesPrecisionBeyondFloat53(): void
    {
        $this->assertSame(
            '100000000000000.000003',
            (new SumOf(
                new DecimalOf('100000000000000.000001'),
                new DecimalOf('0.000002'),
                6,
            ))->asString(),
        );
    }

    #[Test]
    public function returnsIntProjectionTruncatedTowardZero(): void
    {
        $this->assertSame(
            3,
            (new SumOf(new DecimalOf('1.7'), new DecimalOf('1.5'), 1))->asInt(),
        );
    }

    #[Test]
    public function returnsFloatProjection(): void
    {
        $this->assertSame(
            4.0,
            (new SumOf(new DecimalOf('1.5'), new DecimalOf('2.5'), 1))->asFloat(),
        );
    }

    #[Test]
    public function returnsTextProjection(): void
    {
        $this->assertSame(
            '4.0',
            (new SumOf(new DecimalOf('1.5'), new DecimalOf('2.5'), 1))->asText()->value(),
        );
    }
}
