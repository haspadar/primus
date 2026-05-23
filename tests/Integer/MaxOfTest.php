<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\IntegerOf;
use Primus\Integer\MaxOf;
use UnderflowException;

final class MaxOfTest extends TestCase
{
    #[Test]
    public function picksLargestPositive(): void
    {
        $this->assertSame(
            9,
            (new MaxOf(new IntegerOf(3), new IntegerOf(9), new IntegerOf(5)))->asInt(),
        );
    }

    #[Test]
    public function picksLargestWithNegatives(): void
    {
        $this->assertSame(
            -2,
            (new MaxOf(new IntegerOf(-7), new IntegerOf(-2), new IntegerOf(-5)))->asInt(),
        );
    }

    #[Test]
    public function returnsFloatOfMaximum(): void
    {
        $this->assertSame(
            9.0,
            (new MaxOf(new IntegerOf(3), new IntegerOf(9)))->asFloat(),
        );
    }

    #[Test]
    public function returnsTextOfMaximum(): void
    {
        $this->assertSame(
            '9',
            (new MaxOf(new IntegerOf(3), new IntegerOf(9)))->asText()->value(),
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

    #[Test]
    public function integersFactoryAgreesWithPrimaryConstructor(): void
    {
        $a = new IntegerOf(3);
        $b = new IntegerOf(9);

        $this->assertSame(
            (new MaxOf($a, $b))->asInt(),
            MaxOf::integers($a, $b)->asInt(),
        );
    }
}
