<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOfScalar;
use Primus\Scalar\ScalarOf;

final class DecimalOfScalarTest extends TestCase
{
    #[Test]
    public function liftsNumericStringFromScalar(): void
    {
        $this->assertSame(
            '3.14',
            (new DecimalOfScalar(new ScalarOf(static fn(): string => '3.14')))->asString(),
        );
    }

    #[Test]
    public function truncatesIntProjectionTowardZero(): void
    {
        $this->assertSame(
            3,
            (new DecimalOfScalar(new ScalarOf(static fn(): string => '3.99')))->asInt(),
        );
    }

    #[Test]
    public function returnsFloatProjection(): void
    {
        $this->assertSame(
            3.14,
            (new DecimalOfScalar(new ScalarOf(static fn(): string => '3.14')))->asFloat(),
        );
    }

    #[Test]
    public function returnsTextProjection(): void
    {
        $this->assertSame(
            '3.14',
            (new DecimalOfScalar(new ScalarOf(static fn(): string => '3.14')))->asText()->value(),
        );
    }
}
