<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use DivisionByZeroError;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\IntegerOf;
use Primus\Integer\ModOf;

final class ModOfTest extends TestCase
{
    #[Test]
    public function returnsRemainder(): void
    {
        $this->assertSame(1, (new ModOf(new IntegerOf(7), new IntegerOf(3)))->asInt());
    }

    #[Test]
    public function returnsZeroOnExactDivision(): void
    {
        $this->assertSame(0, (new ModOf(new IntegerOf(6), new IntegerOf(2)))->asInt());
    }

    #[Test]
    public function signFollowsDividendForNegativeDividend(): void
    {
        $this->assertSame(-1, (new ModOf(new IntegerOf(-7), new IntegerOf(3)))->asInt());
    }

    #[Test]
    public function signFollowsDividendForNegativeDivisor(): void
    {
        $this->assertSame(1, (new ModOf(new IntegerOf(7), new IntegerOf(-3)))->asInt());
    }

    #[Test]
    public function returnsFloatOfRemainder(): void
    {
        $this->assertSame(1.0, (new ModOf(new IntegerOf(7), new IntegerOf(3)))->asFloat());
    }

    #[Test]
    public function returnsTextOfRemainder(): void
    {
        $this->assertSame('1', (new ModOf(new IntegerOf(7), new IntegerOf(3)))->asText()->value());
    }

    #[Test]
    public function zeroDivisorRejectsIntAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new ModOf(new IntegerOf(1), new IntegerOf(0)))->asInt();
    }

    #[Test]
    public function zeroDivisorRejectsFloatAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new ModOf(new IntegerOf(1), new IntegerOf(0)))->asFloat();
    }

    #[Test]
    public function zeroDivisorRejectsTextAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new ModOf(new IntegerOf(1), new IntegerOf(0)))->asText();
    }

    #[Test]
    public function integersFactoryAgreesWithPrimaryConstructor(): void
    {
        $dividend = new IntegerOf(7);
        $divisor = new IntegerOf(3);

        $this->assertSame(
            (new ModOf($dividend, $divisor))->asInt(),
            ModOf::integers($dividend, $divisor)->asInt(),
        );
    }
}
