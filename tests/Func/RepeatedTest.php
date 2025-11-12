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
use Primus\Func\Repeated;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.3
 */
final class RepeatedTest extends TestCase
{
    #[Test]
    public function repeatsExactNumberOfTimes(): void
    {
        $calls = 0;
        $func = new FuncOf(function (int $x) use (&$calls): int {
            $calls++;
            return $x + 1;
        });

        self::assertThat(
            new ScalarOf(new FuncOf(fn (): mixed => (new Repeated($func, 3))->apply(5))),
            new HasScalarValue(8)
        );
        self::assertSame(3, $calls, 'Origin must be called exactly N times');
    }

    #[Test]
    public function atLeastOnceWhenZeroTimesRequested(): void
    {
        $calls = 0;
        $func = new FuncOf(function (int $x) use (&$calls): int {
            $calls++;
            return $x * 2;
        });

        self::assertThat(
            new ScalarOf(new FuncOf(fn (): mixed => (new Repeated($func, 0))->apply(7))),
            new HasScalarValue(14)
        );
        self::assertSame(1, $calls, 'Zero times must degrade to one call');
    }

    #[Test]
    public function returnsLastInvocationResult(): void
    {
        $state = 0;
        $func = new FuncOf(function (int $x) use (&$state): int {
            $state++;
            return $state;
        });

        self::assertThat(
            new ScalarOf(new FuncOf(fn (): int => (new Repeated($func, 4))->apply(0))),
            new HasScalarValue(4)
        );
    }
}
