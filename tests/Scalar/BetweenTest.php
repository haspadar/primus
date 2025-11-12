<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Scalar\Between;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasBoolValue;

/**
 * @since 0.3
 */
final class BetweenTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenValueIsInsideRange(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(new FuncOf(fn (): int => 5)),
                new ScalarOf(new FuncOf(fn (): int => 1)),
                new ScalarOf(new FuncOf(fn (): int => 10))
            ),
            new HasBoolValue(true),
        );
    }

    #[Test]
    public function returnsFalseWhenValueEqualsLowerBound(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(new FuncOf(fn (): int => 1)),
                new ScalarOf(new FuncOf(fn (): int => 1)),
                new ScalarOf(new FuncOf(fn (): int => 10))
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function returnsFalseWhenValueEqualsUpperBound(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(new FuncOf(fn (): int => 10)),
                new ScalarOf(new FuncOf(fn (): int => 1)),
                new ScalarOf(new FuncOf(fn (): int => 10))
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function returnsFalseWhenValueIsBelowRange(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(new FuncOf(fn (): int => -2)),
                new ScalarOf(new FuncOf(fn (): int => 1)),
                new ScalarOf(new FuncOf(fn (): int => 10))
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function returnsFalseWhenValueIsAboveRange(): void
    {
        self::assertThat(
            new Between(
                new ScalarOf(new FuncOf(fn (): int => 15)),
                new ScalarOf(new FuncOf(fn (): int => 1)),
                new ScalarOf(new FuncOf(fn (): int => 10))
            ),
            new HasBoolValue(false),
        );
    }
}
