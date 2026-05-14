<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\MinOf;
use Primus\Number\NumberOf;
use UnderflowException;

final class MinOfTest extends TestCase
{
    #[Test]
    public function returnsSmallestIntegerOperand(): void
    {
        $this->assertSame(
            -1,
            (new MinOf(new NumberOf(3), new NumberOf(-1), new NumberOf(2)))->asInt(),
        );
    }

    #[Test]
    public function returnsSmallestFloatOperand(): void
    {
        $this->assertSame(
            0.5,
            (new MinOf(new NumberOf(2.5), new NumberOf(0.5), new NumberOf(1.5)))->asFloat(),
        );
    }

    #[Test]
    public function singleOperandIsItsOwnMinimum(): void
    {
        $this->assertSame(42, (new MinOf(new NumberOf(42)))->asInt());
    }

    #[Test]
    public function picksMinimumAcrossMixedSigns(): void
    {
        $this->assertSame(
            -10,
            (new MinOf(new NumberOf(0), new NumberOf(-10), new NumberOf(10)))->asInt(),
        );
    }

    #[Test]
    public function intProjectionTruncatesFloatBeforeCompare(): void
    {
        $this->assertSame(
            0,
            (new MinOf(new NumberOf(0.9), new NumberOf(1.5)))->asInt(),
        );
    }

    #[Test]
    public function emptyOperandsRejectIntAccess(): void
    {
        $this->expectException(UnderflowException::class);

        (new MinOf())->asInt();
    }

    #[Test]
    public function emptyOperandsRejectFloatAccess(): void
    {
        $this->expectException(UnderflowException::class);

        (new MinOf())->asFloat();
    }

    #[Test]
    public function returnsTextOfMinimum(): void
    {
        $this->assertSame('3', (new MinOf(new NumberOf(9), new NumberOf(3), new NumberOf(5)))->asText());
    }
}
