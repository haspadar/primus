<?php

declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\Iterable_;
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
                new Iterable_([1, 2]),
                new Iterable_([3]),
                new Iterable_([4]),
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
            new Iterable_([10]),
            new Iterable_([20]),
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
            new Iterable_([5]),
            new Iterable_([6]),
        ]);

        self::assertSame([0 => 5, 1 => 6], iterator_to_array($it));
    }
}
