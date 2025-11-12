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
use Primus\Scalar\LessThan;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasBoolValue;

/**
 * @since 0.3
 */
final class LessThanTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenLeftLessThanRight(): void
    {
        self::assertThat(
            new LessThan(
                new ScalarOf(new FuncOf(fn (): int => 3)),
                new ScalarOf(new FuncOf(fn (): int => 8))
            ),
            new HasBoolValue(true),
        );
    }

    #[Test]
    public function returnsFalseWhenLeftEqualsRight(): void
    {
        self::assertThat(
            new LessThan(
                new ScalarOf(new FuncOf(fn (): int => 5)),
                new ScalarOf(new FuncOf(fn (): int => 5))
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function returnsFalseWhenLeftGreaterThanRight(): void
    {
        self::assertThat(
            new LessThan(
                new ScalarOf(new FuncOf(fn (): int => 9)),
                new ScalarOf(new FuncOf(fn (): int => 2))
            ),
            new HasBoolValue(false),
        );
    }
}
