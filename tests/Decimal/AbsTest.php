<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\Abs;
use Primus\Decimal\DecimalOf;

final class AbsTest extends TestCase
{
    #[Test]
    public function flipsNegativeSign(): void
    {
        $this->assertSame(
            '3.14',
            (new Abs(new DecimalOf('-3.14'), 2))->asString(),
        );
    }

    #[Test]
    public function leavesPositiveUnchanged(): void
    {
        $this->assertSame(
            '3.14',
            (new Abs(new DecimalOf('3.14'), 2))->asString(),
        );
    }

    #[Test]
    public function leavesZeroUnchanged(): void
    {
        $this->assertSame(
            '0',
            (new Abs(new DecimalOf('0'), 0))->asString(),
        );
    }

    #[Test]
    public function flipsNegativeZeroToPositive(): void
    {
        $this->assertSame(
            '0.00',
            (new Abs(new DecimalOf('-0.00'), 2))->asString(),
        );
    }

    #[Test]
    public function preservesPrecisionBeyondFloat53AtSufficientScale(): void
    {
        $this->assertSame(
            '100000000000000.000001',
            (new Abs(new DecimalOf('-100000000000000.000001'), 6))->asString(),
        );
    }

    #[Test]
    public function truncatesNegativeBeyondScale(): void
    {
        $this->assertSame(
            '3.1',
            (new Abs(new DecimalOf('-3.14'), 1))->asString(),
        );
    }
}
