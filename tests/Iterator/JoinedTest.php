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
use Primus\Iterator\Joined;
use Primus\Tests\Constraint\HasScalarValues;
use Primus\Tests\Constraint\ThrowsClosure;

/**
 * @since 0.5
 */
final class JoinedTest extends TestCase
{
    #[Test]
    public function joinsMultipleIteratorsIntoSingleSequence(): void
    {
        self::assertThat(
            new Joined([
                new IteratorOf([1, 2]),
                new IteratorOf([3]),
                new IteratorOf([4, 5]),
            ]),
            new HasScalarValues([1, 2, 3, 4, 5]),
        );
    }

    #[Test]
    public function joinsEmptyIterators(): void
    {
        self::assertThat(
            new Joined([
                new IteratorOf([]),
                new IteratorOf([]),
                new IteratorOf([]),
            ]),
            new HasScalarValues([]),
        );
    }

    #[Test]
    public function skipsEmptyIteratorsBetweenNonEmpty(): void
    {
        self::assertThat(
            new Joined([
                new IteratorOf([10]),
                new IteratorOf([]),
                new IteratorOf([]),
                new IteratorOf([20, 30]),
            ]),
            new HasScalarValues([10, 20, 30]),
        );
    }

    #[Test]
    public function preservesOrderAcrossBoundaries(): void
    {
        self::assertThat(
            new Joined([
                new IteratorOf(['A']),
                new IteratorOf(['B', 'C']),
                new IteratorOf(['D']),
            ]),
            new HasScalarValues(['A', 'B', 'C', 'D']),
        );
    }

    #[Test]
    public function throwsWhenCallingCurrentPastEnd(): void
    {
        $it = new Joined([
            new IteratorOf([1]),
            new IteratorOf([]),
        ]);

        $it->rewind();
        $it->next();

        self::assertThat(
            fn (): mixed => $it->current(),
            new ThrowsClosure(\RuntimeException::class),
        );
    }

    #[Test]
    public function throwsWhenCallingNextPastEnd(): void
    {
        $it = new Joined([
            new IteratorOf([1]),
        ]);

        $it->rewind();
        $it->next();

        self::assertThat(
            fn () => $it->next(),
            new ThrowsClosure(\RuntimeException::class),
        );
    }

    #[Test]
    public function rewindingProducesSameValues(): void
    {
        $iterator = new Joined([
            new IteratorOf([1]),
            new IteratorOf([2]),
            new IteratorOf([3]),
        ]);

        $iterator->rewind();
        iterator_to_array($iterator);

        $iterator->rewind();

        self::assertThat(
            iterator_to_array($iterator),
            new HasScalarValues([1, 2, 3]),
        );
    }
}
