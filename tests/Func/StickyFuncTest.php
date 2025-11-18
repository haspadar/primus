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

/**
 * @since 0.3
 */
final class StickyFuncTest extends TestCase
{
    #[Test]
    public function cachesScalarInput(): void
    {
        $sticky = new StickyFunc(
            new FuncOf(fn (int $x): int => random_int(PHP_INT_MIN, PHP_INT_MAX)),
        );

        $a = $sticky->apply(7);
        $b = $sticky->apply(7);

        self::assertSame(
            $a,
            $b,
            'StickyFunc must return the same value for repeated scalar input',
        );
    }

    #[Test]
    public function cachesArrayInput(): void
    {
        $sticky = new StickyFunc(
            new FuncOf(fn (array $x): int => random_int(PHP_INT_MIN, PHP_INT_MAX)),
        );

        $a = $sticky->apply(['a', 'b']);
        $b = $sticky->apply(['a', 'b']);

        self::assertSame(
            $a,
            $b,
            'StickyFunc must return the same value for repeated array input',
        );
    }

    #[Test]
    public function cachesTrueInput(): void
    {
        $sticky = new StickyFunc(
            new FuncOf(fn (bool $x): int => random_int(PHP_INT_MIN, PHP_INT_MAX)),
        );

        $first = $sticky->apply(true);
        $second = $sticky->apply(true);

        self::assertSame(
            $first,
            $second,
            'StickyFunc must cache result for boolean true',
        );
    }

    #[Test]
    public function cachesFalseInput(): void
    {
        $sticky = new StickyFunc(
            new FuncOf(fn (bool $x): int => random_int(PHP_INT_MIN, PHP_INT_MAX)),
        );

        $first = $sticky->apply(false);
        $second = $sticky->apply(false);

        self::assertSame(
            $first,
            $second,
            'StickyFunc must cache result for boolean false',
        );
    }
}
