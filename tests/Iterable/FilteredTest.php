<?php

declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\PredicateOf;
use Primus\Iterable\Filtered;
use Primus\Iterable\Iterable_;
use Primus\Tests\Constraint\HasIteratorValues;

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
                new Iterable_([10, 5, 40, 3]),
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
                new Iterable_([1, 2, 3, 4, 5]),
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
                new Iterable_([1, 3, 5]),
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
                new Iterable_([]),
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
            new Iterable_([1, 2, 3, 4]),
            new PredicateOf(fn (int $x): bool => $x > 2),
        );

        iterator_to_array($filtered->getIterator());

        self::assertThat(
            $filtered,
            new HasIteratorValues([3, 4]),
            'Filtered must produce same sequence after rewind'
        );
    }

}
