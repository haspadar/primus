<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\ScalarOf;
use Primus\Scalar\Xor_;
use Primus\Tests\Constraint\HasScalarBoolValue;

final class Xor_Test extends TestCase
{
    #[Test]
    public function returnsTrueWhenExactlyOneConditionTrue(): void
    {
        self::assertThat(
            new Xor_(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): false => false),
            ),
            new HasScalarBoolValue(true),
            'Xor must return true when exactly one condition is true'
        );
    }

    #[Test]
    public function returnsFalseWhenBothTrue(): void
    {
        self::assertThat(
            new Xor_(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): true => true),
            ),
            new HasScalarBoolValue(false),
            'Xor must return false when both conditions are true'
        );
    }

    #[Test]
    public function returnsFalseWhenBothFalse(): void
    {
        self::assertThat(
            new Xor_(
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): false => false),
            ),
            new HasScalarBoolValue(false),
            'Xor must return false when both conditions are false'
        );
    }

    #[Test]
    public function returnsFalseWhenEvenNumberTrue(): void
    {
        self::assertThat(
            new Xor_(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): true => true),
            ),
            new HasScalarBoolValue(false),
            'Xor must return false when an even number of conditions are true'
        );
    }

    #[Test]
    public function returnsFalseForEmptyParity(): void
    {
        self::assertThat(
            new Xor_(),
            new HasScalarBoolValue(false),
        );
    }
}
