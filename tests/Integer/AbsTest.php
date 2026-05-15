<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\Abs;
use Primus\Integer\IntegerOf;
use TypeError;

final class AbsTest extends TestCase
{
    #[Test]
    public function overflowsOnPhpIntMin(): void
    {
        $this->expectException(TypeError::class);

        (new Abs(new IntegerOf(PHP_INT_MIN)))->asInt();
    }

    #[Test]
    public function leavesPositiveUnchanged(): void
    {
        $this->assertSame(7, (new Abs(new IntegerOf(7)))->asInt());
    }

    #[Test]
    public function flipsNegativeSign(): void
    {
        $this->assertSame(7, (new Abs(new IntegerOf(-7)))->asInt());
    }

    #[Test]
    public function returnsZeroForZeroSource(): void
    {
        $this->assertSame(0, (new Abs(new IntegerOf(0)))->asInt());
    }

    #[Test]
    public function returnsFloatOfAbsolute(): void
    {
        $this->assertSame(7.0, (new Abs(new IntegerOf(-7)))->asFloat());
    }

    #[Test]
    public function returnsTextOfAbsolute(): void
    {
        $this->assertSame('7', (new Abs(new IntegerOf(-7)))->asText()->value());
    }
}
