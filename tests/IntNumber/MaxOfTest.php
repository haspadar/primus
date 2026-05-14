<?php

declare(strict_types=1);

namespace Primus\Tests\IntNumber;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\IntNumber\IntNumberOf;
use Primus\IntNumber\MaxOf;
use UnderflowException;

final class MaxOfTest extends TestCase
{
    #[Test]
    public function picksLargestPositive(): void
    {
        $this->assertSame(
            9,
            (new MaxOf(new IntNumberOf(3), new IntNumberOf(9), new IntNumberOf(5)))->asInt(),
        );
    }

    #[Test]
    public function picksLargestWithNegatives(): void
    {
        $this->assertSame(
            -2,
            (new MaxOf(new IntNumberOf(-7), new IntNumberOf(-2), new IntNumberOf(-5)))->asInt(),
        );
    }

    #[Test]
    public function returnsFloatOfMaximum(): void
    {
        $this->assertSame(
            9.0,
            (new MaxOf(new IntNumberOf(3), new IntNumberOf(9)))->asFloat(),
        );
    }

    #[Test]
    public function returnsTextOfMaximum(): void
    {
        $this->assertSame(
            '9',
            (new MaxOf(new IntNumberOf(3), new IntNumberOf(9)))->asText()->value(),
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
    public function emptyOperandsRejectTextAccess(): void
    {
        $this->expectException(UnderflowException::class);

        (new MaxOf())->asText();
    }
}
