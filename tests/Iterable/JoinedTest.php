<?php

declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\IterableOf;
use Primus\Iterable\Joined;
use Primus\Tests\Constraint\HasIteratorValues;

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
                new IterableOf([1, 2]),
                new IterableOf([3]),
                new IterableOf([4]),
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
            new IterableOf([10]),
            new IterableOf([20]),
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
            new IterableOf([5]),
            new IterableOf([6]),
        ]);

        self::assertSame([0 => 5, 1 => 6], iterator_to_array($it));
    }
}
