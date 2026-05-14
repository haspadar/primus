<?php

declare(strict_types=1);

namespace Primus\Tests\IntNumber;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\IntNumber\IntNumberOf;
use Primus\IntNumber\MinOf;
use UnderflowException;

final class MinOfTest extends TestCase
{
    #[Test]
    public function picksSmallestPositive(): void
    {
        $this->assertSame(
            3,
            (new MinOf(new IntNumberOf(9), new IntNumberOf(3), new IntNumberOf(5)))->asInt(),
        );
    }

    #[Test]
    public function picksSmallestWithNegatives(): void
    {
        $this->assertSame(
            -7,
            (new MinOf(new IntNumberOf(-7), new IntNumberOf(-2), new IntNumberOf(-5)))->asInt(),
        );
    }

    #[Test]
    public function returnsFloatOfMinimum(): void
    {
        $this->assertSame(
            3.0,
            (new MinOf(new IntNumberOf(9), new IntNumberOf(3)))->asFloat(),
        );
    }

    #[Test]
    public function returnsTextOfMinimum(): void
    {
        $this->assertSame(
            '3',
            (new MinOf(new IntNumberOf(9), new IntNumberOf(3)))->asText()->value(),
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
}
