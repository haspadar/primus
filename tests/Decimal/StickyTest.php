<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\DecimalOf;
use Primus\Decimal\Sticky;
use Primus\Tests\Constraint\IsIdempotent;
use Primus\Tests\Decimal\Fakes\CountingDecimal;

final class StickyTest extends TestCase
{
    #[Test]
    public function returnsSameIntOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new DecimalOf('3.14'));

        self::assertThat(
            static fn(): int => $sticky->asInt(),
            new IsIdempotent(3),
        );
    }

    #[Test]
    public function returnsSameFloatOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new DecimalOf('3.14'));

        self::assertThat(
            static fn(): float => $sticky->asFloat(),
            new IsIdempotent(3.14),
        );
    }

    #[Test]
    public function returnsSameStringOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new DecimalOf('3.14'));

        self::assertThat(
            static fn(): string => $sticky->asString(),
            new IsIdempotent('3.14'),
        );
    }

    #[Test]
    public function callsOriginAsStringAtMostOnce(): void
    {
        $origin = new CountingDecimal('3.14');
        $sticky = new Sticky($origin);

        $sticky->asString();
        $sticky->asString();
        $sticky->asString();

        self::assertSame(1, $origin->stringCalls);
    }
}
