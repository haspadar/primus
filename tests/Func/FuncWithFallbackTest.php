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
use Primus\Tests\Constraint\AppliesFuncTo;
use Primus\Tests\Constraint\EqualsValue;
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
            new FuncWithFallback(
                new FuncOf(fn (int $x): int => $x * 2),
                new FuncOf(fn (int $x): int => 0),
            ),
            new AppliesFuncTo(3, new EqualsValue(6)),
            'FuncWithFallback must return the origin result when no exception is thrown'
        );
    }

    #[Test]
    public function returnsFallbackWhenExceptionThrown(): void
    {
        self::assertThat(
            new FuncWithFallback(
                new FuncOf(fn (int $x): int => throw new RuntimeException('boom')),
                new FuncOf(fn (int $x): int => 99),
            ),
            new AppliesFuncTo(1, new EqualsValue(99)),
            'FuncWithFallback must return the fallback result when an exception is thrown'
        );
    }
}
