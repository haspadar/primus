<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use DivisionByZeroError;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOf;
use Primus\Decimal\ModOf;

final class ModOfTest extends TestCase
{
    #[Test]
    public function returnsFractionalRemainder(): void
    {
        $this->assertSame(
            '1.5',
            (new ModOf(new DecimalOf('7.5'), new DecimalOf('2'), 1))->asString(),
        );
    }

    #[Test]
    public function returnsZeroOnExactDivision(): void
    {
        $this->assertSame(
            '0.0',
            (new ModOf(new DecimalOf('6'), new DecimalOf('2'), 1))->asString(),
        );
    }

    #[Test]
    public function signFollowsDividendForNegativeDividend(): void
    {
        $this->assertSame(
            '-1.5',
            (new ModOf(new DecimalOf('-7.5'), new DecimalOf('2'), 1))->asString(),
        );
    }

    #[Test]
    public function signFollowsDividendForNegativeDivisor(): void
    {
        $this->assertSame(
            '1.5',
            (new ModOf(new DecimalOf('7.5'), new DecimalOf('-2'), 1))->asString(),
        );
    }

    #[Test]
    public function zeroDivisorRejectsStringAccess(): void
    {
        $this->expectException(DivisionByZeroError::class);

        (new ModOf(new DecimalOf('1'), new DecimalOf('0'), 4))->asString();
    }
}
