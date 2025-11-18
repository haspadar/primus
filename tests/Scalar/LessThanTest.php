<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\LessThan;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarBoolValue;

/**
 * @since 0.2
 */
final class LessThanTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenLeftLessThanRight(): void
    {
        self::assertThat(
            new LessThan(
                new ScalarOf(fn (): int => 3),
                new ScalarOf(fn (): int => 8)
            ),
            new HasScalarBoolValue(true)
        );
    }

    #[Test]
    public function returnsFalseWhenLeftEqualsRight(): void
    {
        self::assertThat(
            new LessThan(
                new ScalarOf(fn (): int => 5),
                new ScalarOf(fn (): int => 5)
            ),
            new HasScalarBoolValue(false)
        );
    }

    #[Test]
    public function returnsFalseWhenLeftGreaterThanRight(): void
    {
        self::assertThat(
            new LessThan(
                new ScalarOf(fn (): int => 9),
                new ScalarOf(fn (): int => 2)
            ),
            new HasScalarBoolValue(false)
        );
    }
}
