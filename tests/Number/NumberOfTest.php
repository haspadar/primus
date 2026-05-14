<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\NumberOf;

final class NumberOfTest extends TestCase
{
    #[Test]
    public function returnsIntForIntegerSource(): void
    {
        $this->assertSame(42, (new NumberOf(42))->asInt());
    }

    #[Test]
    public function returnsFloatForIntegerSource(): void
    {
        $this->assertSame(42.0, (new NumberOf(42))->asFloat());
    }

    #[Test]
    public function truncatesPositiveFloatTowardZero(): void
    {
        $this->assertSame(3, (new NumberOf(3.7))->asInt());
    }

    #[Test]
    public function truncatesNegativeFloatTowardZero(): void
    {
        $this->assertSame(-3, (new NumberOf(-3.7))->asInt());
    }

    #[Test]
    public function preservesFloatMagnitude(): void
    {
        $this->assertSame(3.14, (new NumberOf(3.14))->asFloat());
    }

    #[Test]
    public function returnsZeroForZeroSource(): void
    {
        $this->assertSame(0, (new NumberOf(0))->asInt());
    }

    #[Test]
    public function returnsTextForIntegerSource(): void
    {
        $this->assertSame('42', (new NumberOf(42))->asString());
    }

    #[Test]
    public function returnsTextForFloatSource(): void
    {
        $this->assertSame('3.14', (new NumberOf(3.14))->asString());
    }

    #[Test]
    public function returnsTextForNegativeSource(): void
    {
        $this->assertSame('-7', (new NumberOf(-7))->asString());
    }
}
