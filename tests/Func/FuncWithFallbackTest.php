<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Func\FuncWithFallback;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarValue;
use RuntimeException;

/**
 * @since 0.3
 */
final class FuncWithFallbackTest extends TestCase
{
    #[Test]
    public function returnsOriginResultWhenNoException(): void
    {
        self::assertThat(
            new ScalarOf(
                new FuncOf(fn (): int => (new FuncWithFallback(
                    new FuncOf(fn (int $x): int => $x * 2),
                    new FuncOf(fn (int $x): int => 0),
                ))->apply(5))
            ),
            new HasScalarValue(10),
        );
    }

    #[Test]
    public function returnsFallbackWhenExceptionThrown(): void
    {
        $func = new FuncWithFallback(
            new FuncOf(fn (int $x): int => throw new RuntimeException('boom')),
            new FuncOf(fn (int $x): int => 99),
        );

        self::assertThat(
            new ScalarOf(
                new FuncOf(fn (): int => $func->apply(1)),
            ),
            new HasScalarValue(99),
        );
    }
}
