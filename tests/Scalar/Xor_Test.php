<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Exception;
use Primus\Func\FuncOf;
use Primus\Scalar\ScalarOf;
use Primus\Scalar\Xor_;
use Primus\Tests\Constraint\HasBoolValue;
use Primus\Tests\Constraint\Throws;

/**
 * @since 0.3
 */
final class Xor_Test extends TestCase
{
    #[Test]
    public function returnsTrueWhenExactlyOneConditionTrue(): void
    {
        self::assertThat(
            new Xor_(
                new ScalarOf(new FuncOf(fn (): bool => true)),
                new ScalarOf(new FuncOf(fn (): bool => false)),
            ),
            new HasBoolValue(true),
        );
    }

    #[Test]
    public function returnsFalseWhenBothTrue(): void
    {
        self::assertThat(
            new Xor_(
                new ScalarOf(new FuncOf(fn (): bool => true)),
                new ScalarOf(new FuncOf(fn (): bool => true)),
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function returnsFalseWhenBothFalse(): void
    {
        self::assertThat(
            new Xor_(
                new ScalarOf(new FuncOf(fn (): bool => false)),
                new ScalarOf(new FuncOf(fn (): bool => false)),
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function returnsFalseWhenEvenNumberTrue(): void
    {
        self::assertThat(
            new Xor_(
                new ScalarOf(new FuncOf(fn (): bool => true)),
                new ScalarOf(new FuncOf(fn (): bool => false)),
                new ScalarOf(new FuncOf(fn (): bool => true)),
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function throwsWhenNoConditionsProvided(): void
    {
        self::assertThat(
            new ScalarOf(
                new FuncOf(fn (): bool => (new Xor_())->value())
            ),
            new Throws(Exception::class),
        );
    }
}
