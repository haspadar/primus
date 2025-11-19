<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\PredicateOf;
use Primus\Iterable\Filtered;
use Primus\Iterable\IterableOf;
use Primus\Tests\Constraint\HasIteratorValues;
use Primus\Tests\Constraint\ThrowsClosure;

/**
 * @since 0.5
 */
final class FilteredTest extends TestCase
{
    #[Test]
    public function yieldsOnlyValuesMatchingPredicate(): void
    {
        self::assertThat(
            new Filtered(
                new IterableOf([10, 5, 40, 3]),
                new PredicateOf(fn (int $x): bool => $x > 10),
            ),
            new HasIteratorValues([40]),
            'Filtered must yield only values matching the predicate'
        );
    }

    #[Test]
    public function yieldsAllEvenValues(): void
    {
        self::assertThat(
            new Filtered(
                new IterableOf([1, 2, 3, 4, 5]),
                new PredicateOf(fn (int $x): bool => $x % 2 === 0),
            ),
            new HasIteratorValues([2, 4]),
            'Filtered must yield all even values'
        );
    }

    #[Test]
    public function yieldsEmptyWhenNoMatch(): void
    {
        self::assertThat(
            new Filtered(
                new IterableOf([1, 3, 5]),
                new PredicateOf(fn (int $x): bool => $x > 10),
            ),
            new HasIteratorValues([]),
            'Filtered must yield empty result when no value matches'
        );
    }

    #[Test]
    public function yieldsEmptyWhenOriginIsEmpty(): void
    {
        self::assertThat(
            new Filtered(
                new IterableOf([]),
                new PredicateOf(fn (int $_): bool => true),
            ),
            new HasIteratorValues([]),
            'Filtered must yield empty result when origin is empty'
        );
    }

    #[Test]
    public function rewindingProducesSameSequence(): void
    {
        $filtered = new Filtered(
            new IterableOf([1, 2, 3, 4]),
            new PredicateOf(fn (int $x): bool => $x > 2),
        );

        iterator_to_array($filtered->getIterator());

        self::assertThat(
            $filtered,
            new HasIteratorValues([3, 4]),
            'Filtered must produce same sequence after rewind'
        );
    }

    #[Test]
    public function currentPastEndThrows(): void
    {
        $filtered = new Filtered(
            new IterableOf([1, 2]),
            new PredicateOf(fn (int $x): bool => $x > 10),
        );

        $it = $filtered->getIterator();
        $it->rewind();

        self::assertThat(
            fn (): mixed => $it->current(),
            new ThrowsClosure(\RuntimeException::class),
            'FilteredIterator::current() past end must throw'
        );
    }

    #[Test]
    public function nextPastEndThrows(): void
    {
        $filtered = new Filtered(
            new IterableOf([1]),
            new PredicateOf(fn (int $x): bool => $x > 10),
        );

        $it = $filtered->getIterator();
        $it->rewind();

        self::assertThat(
            fn (): mixed => $it->next(),
            new ThrowsClosure(\RuntimeException::class),
            'FilteredIterator::next() past end must throw'
        );
    }
}
