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
use Primus\Func\StickyFunc;
use Primus\Tests\Constraint\EqualsValue;

/**
 * @since 0.3
 */
final class StickyFuncTest extends TestCase
{
    #[Test]
    public function cachesScalarInput(): void
    {
        $sticky = new StickyFunc(
            new FuncOf(fn (int $x): int => random_int(PHP_INT_MIN, PHP_INT_MAX))
        );

        $a = $sticky->apply(7);
        $b = $sticky->apply(7);

        self::assertThat($a, new EqualsValue($b));
    }

    #[Test]
    public function cachesArrayInput(): void
    {
        $sticky = new StickyFunc(
            new FuncOf(fn (array $x): int => random_int(PHP_INT_MIN, PHP_INT_MAX))
        );

        $a = $sticky->apply(['a', 'b']);
        $b = $sticky->apply(['a', 'b']);

        self::assertThat($a, new EqualsValue($b));
    }

    #[Test]
    public function cachesTrueInput(): void
    {
        $sticky = new StickyFunc(
            new FuncOf(fn (bool $x): int => random_int(PHP_INT_MIN, PHP_INT_MAX))
        );

        $first = $sticky->apply(true);
        $second = $sticky->apply(true);

        self::assertThat($first, new EqualsValue($second));
    }

    #[Test]
    public function cachesFalseInput(): void
    {
        $sticky = new StickyFunc(
            new FuncOf(fn (bool $x): int => random_int(PHP_INT_MIN, PHP_INT_MAX))
        );

        $first = $sticky->apply(false);
        $second = $sticky->apply(false);

        self::assertThat($first, new EqualsValue($second));
    }
}
