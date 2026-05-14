<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use DivisionByZeroError;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\DivOf;
use Primus\Integer\IntegerOf;

final class DivOfTest extends TestCase
{
    #[Test]
    public function dividesExactly(): void
    {
        $this->assertSame(3, (new DivOf(new IntegerOf(6), new IntegerOf(2)))->asInt());
    }

    #[Test]
    public function truncatesPositiveQuotientTowardZero(): void
    {
        $this->assertSame(3, (new DivOf(new IntegerOf(7), new IntegerOf(2)))->asInt());
    }

    #[Test]
    public function truncatesNegativeQuotientTowardZero(): void
    {
        $this->assertSame(-3, (new DivOf(new IntegerOf(-7), new IntegerOf(2)))->asInt());
    }

    #[Test]
    public function returnsFloatOfQuotient(): void
    {
        $this->assertSame(3.0, (new DivOf(new IntegerOf(7), new IntegerOf(2)))->asFloat());
    }

    #[Test]
    public function returnsTextOfQuotient(): void
    {
        $this->assertSame('3', (new DivOf(new IntegerOf(7), new IntegerOf(2)))->asText()->value());
    }

    #[Test]
    public function zeroDivisorRejectsIntAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new DivOf(new IntegerOf(1), new IntegerOf(0)))->asInt();
    }

    #[Test]
    public function zeroDivisorRejectsFloatAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new DivOf(new IntegerOf(1), new IntegerOf(0)))->asFloat();
    }

    #[Test]
    public function zeroDivisorRejectsTextAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new DivOf(new IntegerOf(1), new IntegerOf(0)))->asText();
    }
}
