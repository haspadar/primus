<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\Or_;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarBoolValue;

final class Or_Test extends TestCase
{
    #[Test]
    public function returnsTrueWhenAtLeastOneTrue(): void
    {
        self::assertThat(
            new Or_(
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): true => true)
            ),
            new HasScalarBoolValue(true),
        );
    }

    #[Test]
    public function returnsFalseWhenAllFalse(): void
    {
        self::assertThat(
            new Or_(
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): false => false)
            ),
            new HasScalarBoolValue(false),
        );
    }

    #[Test]
    public function returnsTrueWhenAllTrue(): void
    {
        self::assertThat(
            new Or_(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): true => true)
            ),
            new HasScalarBoolValue(true),
        );
    }

    #[Test]
    public function returnsFalseForEmptyDisjunction(): void
    {
        self::assertThat(
            new Or_(),
            new HasScalarBoolValue(false),
        );
    }

    #[Test]
    public function ofScalarsFactoryAgreesWithPrimaryConstructor(): void
    {
        $a = new ScalarOf(static fn(): bool => false);
        $b = new ScalarOf(static fn(): bool => true);

        self::assertSame(
            (new Or_($a, $b))->value(),
            Or_::ofScalars($a, $b)->value(),
        );
    }

    #[Test]
    public function ofScalarsFactoryAgreesWithPrimaryConstructorOnEmpty(): void
    {
        self::assertSame(
            (new Or_())->value(),
            Or_::ofScalars()->value(),
        );
    }

    #[Test]
    public function ofScalarsFactoryAgreesWithPrimaryConstructorOnSingleOperand(): void
    {
        $single = new ScalarOf(static fn(): bool => false);

        self::assertSame(
            (new Or_($single))->value(),
            Or_::ofScalars($single)->value(),
        );
    }
}
