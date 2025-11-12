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
use Primus\Scalar\GreaterThan;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasBoolValue;

/**
 * @since 0.3
 */
final class GreaterThanTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenLeftGreaterThanRight(): void
    {
        self::assertThat(
            new GreaterThan(
                new ScalarOf(new FuncOf(fn (): int => 10)),
                new ScalarOf(new FuncOf(fn (): int => 5))
            ),
            new HasBoolValue(true),
        );
    }

    #[Test]
    public function returnsFalseWhenLeftEqualsRight(): void
    {
        self::assertThat(
            new GreaterThan(
                new ScalarOf(new FuncOf(fn (): int => 7)),
                new ScalarOf(new FuncOf(fn (): int => 7))
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function returnsFalseWhenLeftLessThanRight(): void
    {
        self::assertThat(
            new GreaterThan(
                new ScalarOf(new FuncOf(fn (): int => 3)),
                new ScalarOf(new FuncOf(fn (): int => 8))
            ),
            new HasBoolValue(false),
        );
    }
}
