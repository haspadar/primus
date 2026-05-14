<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\IntegerOf;

final class IntegerOfTest extends TestCase
{
    #[Test]
    public function returnsIntForPositiveSource(): void
    {
        $this->assertSame(42, (new IntegerOf(42))->asInt());
    }

    #[Test]
    public function returnsIntForNegativeSource(): void
    {
        $this->assertSame(-7, (new IntegerOf(-7))->asInt());
    }

    #[Test]
    public function returnsIntForZeroSource(): void
    {
        $this->assertSame(0, (new IntegerOf(0))->asInt());
    }

    #[Test]
    public function returnsFloatForIntegerSource(): void
    {
        $this->assertSame(42.0, (new IntegerOf(42))->asFloat());
    }

    #[Test]
    public function returnsFloatForNegativeSource(): void
    {
        $this->assertSame(-7.0, (new IntegerOf(-7))->asFloat());
    }

    #[Test]
    public function returnsTextForPositiveSource(): void
    {
        $this->assertSame('42', (new IntegerOf(42))->asText()->value());
    }

    #[Test]
    public function returnsTextForNegativeSource(): void
    {
        $this->assertSame('-7', (new IntegerOf(-7))->asText()->value());
    }

    #[Test]
    public function preservesPrecisionBeyondFloat53(): void
    {
        $this->assertSame('9007199254740993', (new IntegerOf(9007199254740993))->asText()->value());
    }
}
