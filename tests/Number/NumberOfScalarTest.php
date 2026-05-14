<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\NumberOfScalar;
use Primus\Scalar\ScalarOf;

final class NumberOfScalarTest extends TestCase
{
    #[Test]
    public function liftsIntegerScalar(): void
    {
        $this->assertSame(
            42,
            (new NumberOfScalar(new ScalarOf(static fn(): int => 42)))->asInt(),
        );
    }

    #[Test]
    public function liftsFloatScalar(): void
    {
        $this->assertSame(
            3.14,
            (new NumberOfScalar(new ScalarOf(static fn(): float => 3.14)))->asFloat(),
        );
    }

    #[Test]
    public function truncatesScalarFloatTowardZero(): void
    {
        $this->assertSame(
            2,
            (new NumberOfScalar(new ScalarOf(static fn(): float => 2.9)))->asInt(),
        );
    }

    #[Test]
    public function returnsFloatForIntegerScalar(): void
    {
        $this->assertSame(
            5.0,
            (new NumberOfScalar(new ScalarOf(static fn(): int => 5)))->asFloat(),
        );
    }

    #[Test]
    public function returnsTextForIntegerScalar(): void
    {
        $this->assertSame(
            '42',
            (new NumberOfScalar(new ScalarOf(static fn(): int => 42)))->asText()->value(),
        );
    }

    #[Test]
    public function returnsTextForFloatScalar(): void
    {
        $this->assertSame(
            '3.14',
            (new NumberOfScalar(new ScalarOf(static fn(): float => 3.14)))->asText()->value(),
        );
    }
}
