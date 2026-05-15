<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOf;
use Primus\Decimal\MinOf;

final class MinOfTest extends TestCase
{
    #[Test]
    public function picksSmallerOperand(): void
    {
        $this->assertSame(
            '1.5',
            (new MinOf(new DecimalOf('1.5'), new DecimalOf('2.7'), 1))->asString(),
        );
    }

    #[Test]
    public function picksLeftOnTie(): void
    {
        $this->assertSame(
            '1.5',
            (new MinOf(new DecimalOf('1.5'), new DecimalOf('1.5'), 1))->asString(),
        );
    }

    #[Test]
    public function comparesAtGivenScaleOnly(): void
    {
        $this->assertSame(
            '1.5',
            (new MinOf(new DecimalOf('1.5'), new DecimalOf('1.51'), 1))->asString(),
        );
    }

    #[Test]
    public function picksSmallerOfNegatives(): void
    {
        $this->assertSame(
            '-3.0',
            (new MinOf(new DecimalOf('-3.0'), new DecimalOf('-2.7'), 1))->asString(),
        );
    }

    #[Test]
    public function picksNegativeOverPositive(): void
    {
        $this->assertSame(
            '-2.7',
            (new MinOf(new DecimalOf('-2.7'), new DecimalOf('1.5'), 1))->asString(),
        );
    }

    #[Test]
    public function preservesPrecisionBeyondFloat53(): void
    {
        $this->assertSame(
            '100000000000000.000001',
            (new MinOf(
                new DecimalOf('100000000000000.000001'),
                new DecimalOf('100000000000000.000002'),
                6,
            ))->asString(),
        );
    }
}
