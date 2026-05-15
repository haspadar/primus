<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOf;
use Primus\Decimal\MaxOf;

final class MaxOfTest extends TestCase
{
    #[Test]
    public function picksLargerOperand(): void
    {
        $this->assertSame(
            '2.7',
            (new MaxOf(new DecimalOf('1.5'), new DecimalOf('2.7'), 1))->asString(),
        );
    }

    #[Test]
    public function picksLeftOnTie(): void
    {
        $this->assertSame(
            '1.5',
            (new MaxOf(new DecimalOf('1.5'), new DecimalOf('1.5'), 1))->asString(),
        );
    }

    #[Test]
    public function comparesAtGivenScaleOnly(): void
    {
        $this->assertSame(
            '1.5',
            (new MaxOf(new DecimalOf('1.5'), new DecimalOf('1.51'), 1))->asString(),
        );
    }

    #[Test]
    public function picksLargerOfNegatives(): void
    {
        $this->assertSame(
            '-2.7',
            (new MaxOf(new DecimalOf('-3.0'), new DecimalOf('-2.7'), 1))->asString(),
        );
    }

    #[Test]
    public function picksPositiveOverNegative(): void
    {
        $this->assertSame(
            '1.5',
            (new MaxOf(new DecimalOf('-2.7'), new DecimalOf('1.5'), 1))->asString(),
        );
    }

    #[Test]
    public function preservesPrecisionBeyondFloat53(): void
    {
        $this->assertSame(
            '100000000000000.000002',
            (new MaxOf(
                new DecimalOf('100000000000000.000001'),
                new DecimalOf('100000000000000.000002'),
                6,
            ))->asString(),
        );
    }
}
