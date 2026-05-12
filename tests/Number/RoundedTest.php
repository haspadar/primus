<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\NumberOf;
use Primus\Number\Rounded;

final class RoundedTest extends TestCase
{
    #[Test]
    public function roundsToGivenDecimalPrecision(): void
    {
        $this->assertSame(3.14, (new Rounded(new NumberOf(3.14159), 2))->asFloat());
    }

    #[Test]
    public function roundsHalfAwayFromZeroOnPositive(): void
    {
        $this->assertSame(3.0, (new Rounded(new NumberOf(2.5), 0))->asFloat());
    }

    #[Test]
    public function roundsHalfAwayFromZeroOnNegative(): void
    {
        $this->assertSame(-3.0, (new Rounded(new NumberOf(-2.5), 0))->asFloat());
    }

    #[Test]
    public function zeroPrecisionRoundsToWholeNumber(): void
    {
        $this->assertSame(4.0, (new Rounded(new NumberOf(3.7), 0))->asFloat());
    }

    #[Test]
    public function intAccessorTruncatesRoundedFloat(): void
    {
        $this->assertSame(3, (new Rounded(new NumberOf(3.49), 1))->asInt());
    }

    #[Test]
    public function negativePrecisionRoundsTens(): void
    {
        $this->assertSame(120.0, (new Rounded(new NumberOf(123.4), -1))->asFloat());
    }
}
