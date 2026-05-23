<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\IntegerOf;
use Primus\Integer\SumOf;

final class SumOfTest extends TestCase
{
    #[Test]
    public function sumsTwoPositives(): void
    {
        $this->assertSame(5, (new SumOf(new IntegerOf(2), new IntegerOf(3)))->asInt());
    }

    #[Test]
    public function sumsMixedSigns(): void
    {
        $this->assertSame(-1, (new SumOf(new IntegerOf(2), new IntegerOf(-3)))->asInt());
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
        $this->assertSame(5.0, (new SumOf(new IntegerOf(2), new IntegerOf(3)))->asFloat());
    }

    #[Test]
    public function returnsTextOfSum(): void
    {
        $this->assertSame('5', (new SumOf(new IntegerOf(2), new IntegerOf(3)))->asText()->value());
    }

    #[Test]
    public function integersFactoryAgreesWithPrimaryConstructor(): void
    {
        $a = new IntegerOf(2);
        $b = new IntegerOf(3);

        $this->assertSame(
            (new SumOf($a, $b))->asInt(),
            SumOf::integers($a, $b)->asInt(),
        );
    }

    #[Test]
    public function integersFactoryAgreesWithPrimaryConstructorOnEmptyOperands(): void
    {
        $this->assertSame(
            (new SumOf())->asInt(),
            SumOf::integers()->asInt(),
        );
    }
}
