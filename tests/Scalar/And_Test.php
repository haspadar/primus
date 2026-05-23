<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\And_;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarBoolValue;

final class And_Test extends TestCase
{
    #[Test]
    public function returnsTrueWhenAllTrue(): void
    {
        self::assertThat(
            new And_(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): true => true)
            ),
            new HasScalarBoolValue(true),
        );
    }

    #[Test]
    public function returnsFalseWhenOneIsFalse(): void
    {
        self::assertThat(
            new And_(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): false => false)
            ),
            new HasScalarBoolValue(false),
        );
    }

    #[Test]
    public function returnsFalseWhenAllFalse(): void
    {
        self::assertThat(
            new And_(
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): false => false)
            ),
            new HasScalarBoolValue(false),
        );
    }

    #[Test]
    public function returnsTrueForEmptyConjunction(): void
    {
        self::assertThat(
            new And_(),
            new HasScalarBoolValue(true),
        );
    }

    #[Test]
    public function ofScalarsFactoryAgreesWithPrimaryConstructor(): void
    {
        $a = new ScalarOf(static fn(): bool => true);
        $b = new ScalarOf(static fn(): bool => false);

        self::assertSame(
            (new And_($a, $b))->value(),
            And_::ofScalars($a, $b)->value(),
        );
    }

    #[Test]
    public function ofScalarsFactoryAgreesWithPrimaryConstructorOnEmpty(): void
    {
        self::assertSame(
            (new And_())->value(),
            And_::ofScalars()->value(),
        );
    }

    #[Test]
    public function ofScalarsFactoryAgreesWithPrimaryConstructorOnSingleOperand(): void
    {
        $single = new ScalarOf(static fn(): bool => true);

        self::assertSame(
            (new And_($single))->value(),
            And_::ofScalars($single)->value(),
        );
    }
}
