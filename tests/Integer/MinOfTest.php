<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\IntegerOf;
use Primus\Integer\MinOf;
use UnderflowException;

final class MinOfTest extends TestCase
{
    #[Test]
    public function picksSmallestPositive(): void
    {
        $this->assertSame(
            3,
            (new MinOf(new IntegerOf(9), new IntegerOf(3), new IntegerOf(5)))->asInt(),
        );
    }

    #[Test]
    public function picksSmallestWithNegatives(): void
    {
        $this->assertSame(
            -7,
            (new MinOf(new IntegerOf(-7), new IntegerOf(-2), new IntegerOf(-5)))->asInt(),
        );
    }

    #[Test]
    public function returnsFloatOfMinimum(): void
    {
        $this->assertSame(
            3.0,
            (new MinOf(new IntegerOf(9), new IntegerOf(3)))->asFloat(),
        );
    }

    #[Test]
    public function returnsTextOfMinimum(): void
    {
        $this->assertSame(
            '3',
            (new MinOf(new IntegerOf(9), new IntegerOf(3)))->asText()->value(),
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
    public function emptyOperandsRejectTextAccess(): void
    {
        $this->expectException(UnderflowException::class);

        (new MinOf())->asText();
    }

    #[Test]
    public function integersFactoryAgreesWithPrimaryConstructor(): void
    {
        $a = new IntegerOf(9);
        $b = new IntegerOf(3);

        $this->assertSame(
            (new MinOf($a, $b))->asInt(),
            MinOf::integers($a, $b)->asInt(),
        );
    }
}
