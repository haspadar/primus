<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\IntegerOf;
use Primus\Integer\Sticky;
use Primus\Tests\Constraint\IsIdempotent;

final class StickyTest extends TestCase
{
    #[Test]
    public function returnsSameIntOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new IntegerOf(42));

        self::assertThat(
            static fn(): int => $sticky->asInt(),
            new IsIdempotent(42),
        );
    }

    #[Test]
    public function returnsSameFloatOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new IntegerOf(42));

        self::assertThat(
            static fn(): float => $sticky->asFloat(),
            new IsIdempotent(42.0),
        );
    }

    #[Test]
    public function ofIntegerFactoryAgreesWithPrimaryConstructor(): void
    {
        $integer = new IntegerOf(42);

        $this->assertSame(
            (new Sticky($integer))->asInt(),
            Sticky::ofInteger($integer)->asInt(),
        );
    }
}
