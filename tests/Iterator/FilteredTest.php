<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterator;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\PredicateOf;
use Primus\Iterator\Filtered;
use Primus\Iterator\IteratorOf;
use Primus\Tests\Constraint\HasIteratorValues;
use Primus\Tests\Constraint\HasKey;
use Primus\Tests\Constraint\HasKeyValuePairs;
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
                new IteratorOf([10, 5, 40, 3]),
                new PredicateOf(fn (int $v): bool => $v > 10),
            ),
            new HasIteratorValues([40]),
        );
    }

    #[Test]
    public function yieldsAllEvenValues(): void
    {
        self::assertThat(
            new Filtered(
                new IteratorOf([1, 2, 3, 4, 5]),
                new PredicateOf(fn (int $v): bool => $v % 2 === 0),
            ),
            new HasIteratorValues([2, 4]),
        );
    }

    #[Test]
    public function yieldsEmptyResultWhenNoValueMatches(): void
    {
        self::assertThat(
            new Filtered(
                new IteratorOf([1, 3, 5]),
                new PredicateOf(fn (int $v): bool => $v > 10),
            ),
            new HasIteratorValues([]),
        );
    }

    #[Test]
    public function yieldsEmptyResultWhenOriginIsEmpty(): void
    {
        self::assertThat(
            new Filtered(
                new IteratorOf([]),
                new PredicateOf(fn (int $v): bool => true),
            ),
            new HasIteratorValues([]),
        );
    }

    #[Test]
    public function returnsSameSequenceWhenRewound(): void
    {
        $filtered = new Filtered(
            new IteratorOf([1, 2, 3, 4]),
            new PredicateOf(fn (int $v): bool => $v > 2),
        );

        $filtered->rewind();
        iterator_to_array($filtered);

        $filtered->rewind();

        self::assertThat(
            $filtered,
            new HasKeyValuePairs([2 => 3, 3 => 4]),
        );
    }

    #[Test]
    public function throwsWhenCallingNextPastEnd(): void
    {
        $it = new Filtered(
            new IteratorOf([1, 2]),
            new PredicateOf(fn (int $v): bool => $v > 10),
        );

        $it->rewind();

        self::assertThat(
            fn () => $it->next(),
            new ThrowsClosure(\RuntimeException::class),
        );
    }

    #[Test]
    public function throwsWhenCallingCurrentPastEnd(): void
    {
        $it = new Filtered(
            new IteratorOf([1, 2]),
            new PredicateOf(fn (int $v): bool => $v > 10),
        );

        $it->rewind();

        self::assertThat(
            fn (): mixed => $it->current(),
            new ThrowsClosure(\RuntimeException::class),
        );
    }

    #[Test]
    public function incrementsKeyOnlyForAcceptedValues(): void
    {
        $it = new Filtered(
            new IteratorOf([1, 10, 2, 20]),
            new PredicateOf(fn (int $v): bool => $v > 5),
        );

        $it->rewind();
        $it->next();

        self::assertThat(
            $it,
            new HasKey(3),
        );
    }
}
