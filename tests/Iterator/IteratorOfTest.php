<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterator;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterator\IteratorOf;
use Primus\Tests\Constraint\EqualsValue;
use Primus\Tests\Constraint\HasScalarValues;
use Primus\Tests\Constraint\ThrowsClosure;

/**
 * @since 0.5
 */
final class IteratorOfTest extends TestCase
{
    #[Test]
    public function returnsFirstElementWhenRewound(): void
    {
        $it = new IteratorOf([10, 20, 30]);
        $it->rewind();

        self::assertThat(
            $it->current(),
            new EqualsValue(10),
        );
    }

    #[Test]
    public function movesForwardSequentially(): void
    {
        $it = new IteratorOf([5, 7, 9]);

        $it->rewind();
        $it->next();

        self::assertThat(
            $it->current(),
            new EqualsValue(7),
        );
    }

    #[Test]
    public function keyMatchesCurrentPosition(): void
    {
        $it = new IteratorOf([1, 2, 3]);

        $it->rewind();
        $it->next();

        self::assertThat(
            $it->key(),
            new EqualsValue(1),
        );
    }

    #[Test]
    public function validIsFalseWhenPastEnd(): void
    {
        $it = new IteratorOf([42]);

        $it->rewind();
        $it->next();

        self::assertThat(
            $it->valid(),
            new EqualsValue(false),
        );
    }

    #[Test]
    public function iteratesThroughAllElements(): void
    {
        self::assertThat(
            new IteratorOf(['a', 'b']),
            new HasScalarValues(['a', 'b']),
        );
    }

    #[Test]
    public function emptyIteratorHasNoElements(): void
    {
        self::assertThat(
            new IteratorOf([]),
            new HasScalarValues([]),
        );
    }

    #[Test]
    public function currentOnInvalidPositionThrows(): void
    {
        $it = new IteratorOf([1]);

        $it->rewind();
        $it->next();

        self::assertThat(
            fn (): mixed => $it->current(),
            new ThrowsClosure(\RuntimeException::class),
        );
    }
}
