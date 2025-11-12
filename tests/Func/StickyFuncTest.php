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
use Primus\Tests\CallCounter;

/**
 * @since 0.3
 */
final class StickyFuncTest extends TestCase
{
    #[Test]
    public function cachesScalarInput(): void
    {
        $counter = new CallCounter();

        $sticky = new StickyFunc(
            new FuncOf(fn (int $x): int => $counter->increment() * $x)
        );

        $sticky->apply(7);
        $sticky->apply(7);

        self::assertSame(1, $counter->total(), 'Should call origin only once for same scalar');
    }

    #[Test]
    public function cachesArrayInput(): void
    {
        $counter = new CallCounter();

        $sticky = new StickyFunc(
            new FuncOf(fn (array $input): int => $counter->increment() + count($input))
        );

        $sticky->apply(['a', 'b']);
        $sticky->apply(['a', 'b']);

        self::assertSame(1, $counter->total(), 'Should call origin only once for same array');
    }

    #[Test]
    public function cachesObjectInput(): void
    {
        $counter = new CallCounter();

        $sticky = new StickyFunc(
            new FuncOf(fn (object $input): int => $counter->increment() + strlen($input::class))
        );

        $object = new \stdClass();
        $sticky->apply($object);
        $sticky->apply($object);

        self::assertSame(1, $counter->total(), 'Should call origin only once for same object');
    }

    #[Test]
    public function cachesBooleanInput(): void
    {
        $counter = new CallCounter();

        $sticky = new StickyFunc(
            new FuncOf(fn (bool $input): int => $counter->increment() + ($input ? 1 : 0))
        );

        $sticky->apply(true);
        $sticky->apply(true);
        $sticky->apply(false);
        $sticky->apply(false);

        self::assertSame(2, $counter->total(), 'Should call origin only once per boolean value');
    }
}
