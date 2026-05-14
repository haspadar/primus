<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\NumberOf;
use Primus\Number\SumOf;

final class SumOfTest extends TestCase
{
    #[Test]
    public function sumsTwoIntegers(): void
    {
        $this->assertSame(5, (new SumOf(new NumberOf(2), new NumberOf(3)))->asInt());
    }

    #[Test]
    public function sumsMixedIntegerAndFloat(): void
    {
        $this->assertSame(3.5, (new SumOf(new NumberOf(1), new NumberOf(2.5)))->asFloat());
    }

    #[Test]
    public function truncatesFractionalSumOnIntAccessor(): void
    {
        $this->assertSame(3, (new SumOf(new NumberOf(1), new NumberOf(2.7)))->asInt());
    }

    #[Test]
    public function truncatesSumAfterAddingFloatsRatherThanEachAddend(): void
    {
        $this->assertSame(1, (new SumOf(new NumberOf(0.9), new NumberOf(0.9)))->asInt());
    }

    #[Test]
    public function sumsAcrossManyOperands(): void
    {
        $this->assertSame(
            10,
            (new SumOf(
                new NumberOf(1),
                new NumberOf(2),
                new NumberOf(3),
                new NumberOf(4),
            ))->asInt(),
        );
    }

    #[Test]
    public function sumsNegativeAndPositive(): void
    {
        $this->assertSame(-2, (new SumOf(new NumberOf(3), new NumberOf(-5)))->asInt());
    }

    #[Test]
    public function emptySumIsZeroInt(): void
    {
        $this->assertSame(0, (new SumOf())->asInt());
    }

    #[Test]
    public function emptySumIsZeroFloat(): void
    {
        $this->assertSame(0.0, (new SumOf())->asFloat());
    }

    #[Test]
    public function returnsTextOfIntegerSum(): void
    {
        $this->assertSame('5', (new SumOf(new NumberOf(2), new NumberOf(3)))->asText());
    }

    #[Test]
    public function returnsTextOfFractionalSum(): void
    {
        $this->assertSame('3.5', (new SumOf(new NumberOf(1), new NumberOf(2.5)))->asText());
    }

    #[Test]
    public function emptySumIsZeroText(): void
    {
        $this->assertSame('0', (new SumOf())->asText());
    }
}
