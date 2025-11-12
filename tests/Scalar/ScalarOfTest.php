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
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasBoolValue;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.3
 */
final class ScalarOfTest extends TestCase
{
    #[Test]
    public function returnsEvaluatedValue(): void
    {
        self::assertThat(
            new ScalarOf(new FuncOf(fn (): int => 42)),
            new HasScalarValue(42)
        );
    }

    #[Test]
    public function invokesFunctionWhenValueIsCalled(): void
    {
        $called = false;

        (new ScalarOf(new FuncOf(function () use (&$called): int {
            $called = true;
            return 1;
        })))->value();

        self::assertThat(
            new ScalarOf(new FuncOf(fn (): bool => $called)),
            new HasBoolValue(true)
        );
    }
}
