<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\Joined;
use Primus\Iterator\IteratorOf;
use Primus\Tests\Constraint\EqualsValue;
use Primus\Tests\Constraint\HasIteratorValues;
use Primus\Tests\Constraint\ThrowsClosure;

/**
 * @since 0.5
 */
final class JoinedTest extends TestCase
{
    #[Test]
    public function concatenatesAllValues(): void
    {
        self::assertThat(
            new Joined([
                new IteratorOf([1, 2]),
                new IteratorOf([3]),
                new IteratorOf([4]),
            ]),
            new HasIteratorValues([1, 2, 3, 4]),
        );
    }

    #[Test]
    public function emptyWhenNoIterators(): void
    {
        self::assertThat(
            new Joined([]),
            new HasIteratorValues([]),
        );
    }

    #[Test]
    public function producesSameValuesOnSecondIteration(): void
    {
        $joined = new Joined([
            new IteratorOf([10]),
            new IteratorOf([20]),
        ]);

        iterator_to_array($joined);

        self::assertThat(
            $joined,
            new HasIteratorValues([10, 20]),
        );
    }

    #[Test]
    public function keysAreSequential(): void
    {
        $it = new Joined([
            new IteratorOf([5]),
            new IteratorOf([6]),
        ]);

        self::assertThat(
            iterator_to_array($it),
            new EqualsValue([0 => 5, 1 => 6]),
        );
    }

    #[Test]
    public function currentThrowsExceptionPastEnd(): void
    {
        $it = (new Joined([
            new IteratorOf([1]),
        ]))->getIterator();

        $it->rewind();
        $it->next();

        self::assertThat(
            fn (): mixed => $it->current(),
            new ThrowsClosure(\RuntimeException::class),
        );
    }
}
