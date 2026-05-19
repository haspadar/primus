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
}
