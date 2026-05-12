<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\And_;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarBoolValue;
use Primus\Tests\Constraint\ThrowsValue;

/**
 */
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
            'And must return true when all scalars are true'
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
            'And must return false when at least one scalar is false'
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
            'And must return false when all scalars are false'
        );
    }

    #[Test]
    public function throwsWhenNoScalarsProvided(): void
    {
        self::assertThat(
            new ScalarOf(fn () => (new And_())->value()),
            new ThrowsValue(InvalidArgumentException::class),
            'And must throw an exception when no scalars are provided'
        );
    }
}
