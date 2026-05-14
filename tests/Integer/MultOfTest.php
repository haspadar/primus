<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\IntegerOf;
use Primus\Integer\MultOf;

final class MultOfTest extends TestCase
{
    #[Test]
    public function multipliesTwoPositives(): void
    {
        $this->assertSame(12, (new MultOf(new IntegerOf(3), new IntegerOf(4)))->asInt());
    }

    #[Test]
    public function multipliesMixedSigns(): void
    {
        $this->assertSame(-12, (new MultOf(new IntegerOf(3), new IntegerOf(-4)))->asInt());
    }

    #[Test]
    public function zeroFactorYieldsZero(): void
    {
        $this->assertSame(0, (new MultOf(new IntegerOf(5), new IntegerOf(0)))->asInt());
    }

    #[Test]
    public function emptyProductIsOneInt(): void
    {
        $this->assertSame(1, (new MultOf())->asInt());
    }

    #[Test]
    public function emptyProductIsOneFloat(): void
    {
        $this->assertSame(1.0, (new MultOf())->asFloat());
    }

    #[Test]
    public function emptyProductIsOneText(): void
    {
        $this->assertSame('1', (new MultOf())->asText()->value());
    }

    #[Test]
    public function returnsFloatOfProduct(): void
    {
        $this->assertSame(12.0, (new MultOf(new IntegerOf(3), new IntegerOf(4)))->asFloat());
    }

    #[Test]
    public function returnsTextOfProduct(): void
    {
        $this->assertSame('12', (new MultOf(new IntegerOf(3), new IntegerOf(4)))->asText()->value());
    }
}
