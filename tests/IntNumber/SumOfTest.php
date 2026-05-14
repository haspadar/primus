<?php

declare(strict_types=1);

namespace Primus\Tests\IntNumber;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\IntNumber\IntNumberOf;
use Primus\IntNumber\SumOf;

final class SumOfTest extends TestCase
{
    #[Test]
    public function sumsTwoPositives(): void
    {
        $this->assertSame(5, (new SumOf(new IntNumberOf(2), new IntNumberOf(3)))->asInt());
    }

    #[Test]
    public function sumsMixedSigns(): void
    {
        $this->assertSame(-1, (new SumOf(new IntNumberOf(2), new IntNumberOf(-3)))->asInt());
    }

    #[Test]
    public function emptySumIsZeroInt(): void
    {
        $this->assertSame(0, (new SumOf())->asInt());
    }

    #[Test]
    public function emptySumIsZeroFloat(): void
    {
        $this->assertSame(0.0, (new SumOf())->asFloat());
    }

    #[Test]
    public function emptySumIsZeroText(): void
    {
        $this->assertSame('0', (new SumOf())->asText()->value());
    }

    #[Test]
    public function returnsFloatOfSum(): void
    {
        $this->assertSame(5.0, (new SumOf(new IntNumberOf(2), new IntNumberOf(3)))->asFloat());
    }

    #[Test]
    public function returnsTextOfSum(): void
    {
        $this->assertSame('5', (new SumOf(new IntNumberOf(2), new IntNumberOf(3)))->asText()->value());
    }
}
