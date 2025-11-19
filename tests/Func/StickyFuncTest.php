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
use Primus\Tests\Constraint\HasCallCount;
use Primus\Tests\CountCalls;

/**
 * @since 0.3
 */
final class StickyFuncTest extends TestCase
{
    #[Test]
    public function cachesArrayInput(): void
    {
        $calls = new CountCalls();

        $sticky = new StickyFunc(
            new FuncOf(fn (array $x): int => $calls->record(count($x)))
        );

        self::assertThat(
            $sticky->apply(['a', 'b']),
            new EqualsValue($sticky->apply(['a', 'b']))
        );

        self::assertThat($calls, new HasCallCount(1));
    }

    #[Test]
    public function cachesTrueInput(): void
    {
        $calls = new CountCalls();

        $sticky = new StickyFunc(
            new FuncOf(fn (bool $x): int => $calls->record($x ? 1 : 0))
        );

        self::assertThat(
            $sticky->apply(true),
            new EqualsValue($sticky->apply(true))
        );

        self::assertThat($calls, new HasCallCount(1));
    }

    #[Test]
    public function cachesFalseInput(): void
    {
        $calls = new CountCalls();

        $sticky = new StickyFunc(
            new FuncOf(fn (bool $x): int => $calls->record($x ? 1 : 0))
        );

        self::assertThat(
            $sticky->apply(false),
            new EqualsValue($sticky->apply(false))
        );

        self::assertThat($calls, new HasCallCount(1));
    }
}
