<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use DivisionByZeroError;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOf;
use Primus\Decimal\DivOf;

final class DivOfTest extends TestCase
{
    #[Test]
    public function dividesExactly(): void
    {
        $this->assertSame(
            '3.00',
            (new DivOf(new DecimalOf('6'), new DecimalOf('2'), 2))->asString(),
        );
    }

    #[Test]
    public function truncatesRepeatingDecimalAtScale(): void
    {
        $this->assertSame(
            '0.3333',
            (new DivOf(new DecimalOf('1'), new DecimalOf('3'), 4))->asString(),
        );
    }

    #[Test]
    public function truncatesNegativeQuotientTowardZero(): void
    {
        $this->assertSame(
            '-3.5',
            (new DivOf(new DecimalOf('-7'), new DecimalOf('2'), 1))->asString(),
        );
    }

    #[Test]
    public function preservesPrecisionBeyondFloat53(): void
    {
        $this->assertSame(
            '50000000000000.000000',
            (new DivOf(
                new DecimalOf('100000000000000.000001'),
                new DecimalOf('2'),
                6,
            ))->asString(),
        );
    }

    #[Test]
    public function zeroDivisorRejectsStringAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new DivOf(new DecimalOf('1'), new DecimalOf('0'), 4))->asString();
    }
}
