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

/**
 * @since 0.3
 */
final class RepeatedTest extends TestCase
{
    #[Test]
    public function repeatsExactNumberOfTimes(): void
    {
        $values = [1, 2, 5, 6];
        $func = new FuncOf(
            function (int $x) use (&$values): int {
                return array_shift($values);
            },
        );

        self::assertSame(
            5,
            (new Repeated($func, 3))->apply(0),
            'Repeated must return the 3rd produced value',
        );
    }

    #[Test]
    public function repeatsNullResults(): void
    {
        $func = new FuncOf(fn (): mixed => null);

        self::assertSame(
            null,
            (new Repeated($func, 2))->apply(null),
            'Repeated must return null when origin returns null',
        );
    }

    #[Test]
    public function returnsLastInvocationResult(): void
    {
        $values = [10, 20, 30, 40];
        $func = new FuncOf(
            function () use (&$values): int {
                return array_shift($values);
            },
        );

        self::assertSame(
            40,
            (new Repeated($func, 4))->apply(0),
            'Repeated must return the last invocation result',
        );
    }
}
