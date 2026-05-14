<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use DivisionByZeroError;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\AvgOf;
use Primus\Number\NumberOf;

final class AvgOfTest extends TestCase
{
    #[Test]
    public function averagesThreeIntegers(): void
    {
        $this->assertSame(3.0, (new AvgOf(new NumberOf(1), new NumberOf(2), new NumberOf(6)))->asFloat());
    }

    #[Test]
    public function averagesMixedIntegerAndFloat(): void
    {
        $this->assertSame(2.25, (new AvgOf(new NumberOf(2), new NumberOf(2.5)))->asFloat());
    }

    #[Test]
    public function truncatesPositiveFractionalAverageOnIntAccessor(): void
    {
        $this->assertSame(2, (new AvgOf(new NumberOf(1), new NumberOf(2), new NumberOf(4)))->asInt());
    }

    #[Test]
    public function truncatesNegativeFractionalAverageTowardZeroOnIntAccessor(): void
    {
        $this->assertSame(-2, (new AvgOf(new NumberOf(-1), new NumberOf(-2), new NumberOf(-4)))->asInt());
    }

    #[Test]
    public function singleOperandIsItsOwnAverageAsFloat(): void
    {
        $this->assertSame(7.0, (new AvgOf(new NumberOf(7)))->asFloat());
    }

    #[Test]
    public function singleOperandIsItsOwnAverageAsInt(): void
    {
        $this->assertSame(7, (new AvgOf(new NumberOf(7)))->asInt());
    }

    #[Test]
    public function averagesAcrossNegativeAndPositive(): void
    {
        $this->assertSame(0.0, (new AvgOf(new NumberOf(-5), new NumberOf(5)))->asFloat());
    }

    #[Test]
    public function emptyOperandsRejectFloatAccessWithDivisionByZero(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new AvgOf())->asFloat();
    }

    #[Test]
    public function emptyOperandsRejectIntAccessWithDivisionByZero(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new AvgOf())->asInt();
    }

    #[Test]
    public function returnsTextOfAverage(): void
    {
        $this->assertSame('2', (new AvgOf(new NumberOf(1), new NumberOf(2), new NumberOf(3)))->asText()->value());
    }
}
