<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\Between;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarBoolValue;

/**
 * @since 0.2
 */
final class BetweenTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenValueIsInsideRange(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(fn (): int => 5),
                new ScalarOf(fn (): int => 1),
                new ScalarOf(fn (): int => 10)
            ),
            new HasScalarBoolValue(true)
        );
    }

    #[Test]
    public function returnsFalseWhenValueEqualsLowerBound(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(fn (): int => 1),
                new ScalarOf(fn (): int => 1),
                new ScalarOf(fn (): int => 10)
            ),
            new HasScalarBoolValue(false)
        );
    }

    #[Test]
    public function returnsFalseWhenValueEqualsUpperBound(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(fn (): int => 10),
                new ScalarOf(fn (): int => 1),
                new ScalarOf(fn (): int => 10)
            ),
            new HasScalarBoolValue(false)
        );
    }

    #[Test]
    public function returnsFalseWhenValueIsBelowRange(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(fn (): int => -2),
                new ScalarOf(fn (): int => 1),
                new ScalarOf(fn (): int => 10)
            ),
            new HasScalarBoolValue(false)
        );
    }

    #[Test]
    public function returnsFalseWhenValueIsAboveRange(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(fn (): int => 15),
                new ScalarOf(fn (): int => 1),
                new ScalarOf(fn (): int => 10)
            ),
            new HasScalarBoolValue(false)
        );
    }
}
