<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\MaxOf;
use Primus\Number\NumberOf;
use UnderflowException;

final class MaxOfTest extends TestCase
{
    #[Test]
    public function returnsLargestIntegerOperand(): void
    {
        $this->assertSame(
            3,
            (new MaxOf(new NumberOf(3), new NumberOf(-1), new NumberOf(2)))->asInt(),
        );
    }

    #[Test]
    public function returnsLargestFloatOperand(): void
    {
        $this->assertSame(
            2.5,
            (new MaxOf(new NumberOf(0.5), new NumberOf(2.5), new NumberOf(1.5)))->asFloat(),
        );
    }

    #[Test]
    public function singleOperandIsItsOwnMaximumAsFloat(): void
    {
        $this->assertSame(42.0, (new MaxOf(new NumberOf(42)))->asFloat());
    }

    #[Test]
    public function singleOperandIsItsOwnMaximumAsInt(): void
    {
        $this->assertSame(42, (new MaxOf(new NumberOf(42)))->asInt());
    }

    #[Test]
    public function picksMaximumAcrossMixedSigns(): void
    {
        $this->assertSame(
            10,
            (new MaxOf(new NumberOf(0), new NumberOf(-10), new NumberOf(10)))->asInt(),
        );
    }

    #[Test]
    public function intProjectionTruncatesFloatBeforeCompare(): void
    {
        $this->assertSame(
            1,
            (new MaxOf(new NumberOf(0.9), new NumberOf(1.5)))->asInt(),
        );
    }

    #[Test]
    public function emptyOperandsRejectIntAccess(): void
    {
        $this->expectException(UnderflowException::class);

        (new MaxOf())->asInt();
    }

    #[Test]
    public function emptyOperandsRejectFloatAccess(): void
    {
        $this->expectException(UnderflowException::class);

        (new MaxOf())->asFloat();
    }

    #[Test]
    public function returnsTextOfMaximum(): void
    {
        $this->assertSame('9', (new MaxOf(new NumberOf(3), new NumberOf(9), new NumberOf(5)))->asText()->value());
    }
}
