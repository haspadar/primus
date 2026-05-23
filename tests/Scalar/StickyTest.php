<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\ScalarOf;
use Primus\Scalar\Sticky;
use Primus\Tests\Constraint\HasScalarValue;

/**
 */
final class StickyTest extends TestCase
{
    #[Test]
    public function cachesValue(): void
    {
        $scalar = new Sticky(new ScalarOf(fn (): string => uniqid('', true)));

        self::assertSame(
            $scalar->value(),
            $scalar->value(),
            'Sticky should return the same cached value'
        );
    }

    #[Test]
    public function returnsStoredValue(): void
    {
        self::assertThat(
            new Sticky(new ScalarOf(fn (): int => 42)),
            new HasScalarValue(42),
            'Sticky must return the stored value'
        );
    }

    #[Test]
    public function ofScalarFactoryAgreesWithPrimaryConstructor(): void
    {
        $scalar = new ScalarOf(static fn(): int => 42);

        self::assertSame(
            (new Sticky($scalar))->value(),
            Sticky::ofScalar($scalar)->value(),
        );
    }
}
