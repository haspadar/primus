<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use DivisionByZeroError;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\DivOf;
use Primus\Number\MultOf;
use Primus\Number\NumberOf;

final class DivOfTest extends TestCase
{
    #[Test]
    public function dividesTwoIntegersAsFloat(): void
    {
        $this->assertSame(3.5, (new DivOf(new NumberOf(7), new NumberOf(2)))->asFloat());
    }

    #[Test]
    public function truncatesQuotientOnIntAccessor(): void
    {
        $this->assertSame(3, (new DivOf(new NumberOf(7), new NumberOf(2)))->asInt());
    }

    #[Test]
    public function dividesNegativeDividend(): void
    {
        $this->assertSame(-2.5, (new DivOf(new NumberOf(-5), new NumberOf(2)))->asFloat());
    }

    #[Test]
    public function dividesIntoFractionalResult(): void
    {
        $this->assertSame(0.25, (new DivOf(new NumberOf(1), new NumberOf(4)))->asFloat());
    }

    #[Test]
    public function percentFormulaComposesDivWithMult(): void
    {
        $this->assertSame(
            87.5,
            (new MultOf(
                new DivOf(new NumberOf(7), new NumberOf(8)),
                new NumberOf(100),
            ))->asFloat(),
        );
    }

    #[Test]
    public function zeroDivisorThrowsOnFloatAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new DivOf(new NumberOf(1), new NumberOf(0)))->asFloat();
    }

    #[Test]
    public function zeroDivisorThrowsOnIntAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new DivOf(new NumberOf(1), new NumberOf(0)))->asInt();
    }
}
