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
use Primus\Scalar\And_;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasBoolValue;
use Primus\Tests\Constraint\Throws;

/**
 * @since 0.3
 */
final class And_Test extends TestCase
{
    #[Test]
    public function returnsTrueWhenAllTrue(): void
    {
        self::assertThat(
            new And_(
                new ScalarOf(new FuncOf(fn (): bool => true)),
                new ScalarOf(new FuncOf(fn (): bool => true)),
            ),
            new HasBoolValue(true),
        );
    }

    #[Test]
    public function returnsFalseWhenOneIsFalse(): void
    {
        self::assertThat(
            new And_(
                new ScalarOf(new FuncOf(fn (): bool => true)),
                new ScalarOf(new FuncOf(fn (): bool => false)),
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function returnsFalseWhenAllFalse(): void
    {
        self::assertThat(
            new And_(
                new ScalarOf(new FuncOf(fn (): bool => false)),
                new ScalarOf(new FuncOf(fn (): bool => false)),
            ),
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function throwsWhenNoScalarsProvided(): void
    {
        self::assertThat(
            new ScalarOf(
                new FuncOf(fn (): bool => (new And_())->value())
            ),
            new Throws(Exception::class),
        );
    }
}
