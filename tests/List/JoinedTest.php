<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use Generator;
use Override;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\Joined;
use Primus\List\List_;
use Primus\List\ListOf;

final class JoinedTest extends TestCase
{
    #[Test]
    public function joinsZeroSourcesIntoEmptyList(): void
    {
        $this->assertSame([], (new Joined())->value());
    }

    #[Test]
    public function joinsSingleSourcePreservingOrder(): void
    {
        $this->assertSame(
            [1, 2, 3],
            (new Joined(new ListOf(1, 2, 3)))->value(),
        );
    }

    #[Test]
    public function concatenatesSourcesInOrder(): void
    {
        $this->assertSame(
            [1, 2, 3, 4, 5],
            (new Joined(
                new ListOf(1, 2),
                new ListOf(3, 4, 5),
            ))->value(),
        );
    }

    #[Test]
    public function reindexesKeysSequentiallyFromZero(): void
    {
        $this->assertSame(
            [0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd'],
            (new Joined(
                new ListOf('a', 'b'),
                new ListOf('c', 'd'),
            ))->value(),
        );
    }

    #[Test]
    public function reindexesEvenWhenSourceExposesNonSequentialKeys(): void
    {
        $stringKeyed = new readonly class implements List_ {
            #[Override]
            public function value(): array
            {
                return ['x' => 'a', 'y' => 'b'];
            }

            #[Override]
            public function count(): int
            {
                return count($this->value());
            }

            #[Override]
            public function getIterator(): Generator
            {
                yield from $this->value();
            }
        };

        $this->assertSame(
            [0 => 'a', 1 => 'b', 2 => 'c'],
            (new Joined($stringKeyed, new ListOf('c')))->value(),
        );
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $joined = new Joined(
            new ListOf(1, 2),
            new ListOf(3, 4),
        );
        $this->assertSame(
            $joined->value(),
            iterator_to_array($joined),
        );
    }

    #[Test]
    public function countsAcrossAllSources(): void
    {
        $this->assertCount(
            5,
            new Joined(
                new ListOf('a'),
                new ListOf('b', 'c'),
                new ListOf('d', 'e'),
            ),
        );
    }

    #[Test]
    public function leavesSourcesUntouchedAfterReading(): void
    {
        $first = new ListOf(1, 2);
        $second = new ListOf(3, 4);
        $joined = new Joined($first, $second);
        $joined->value();
        iterator_to_array($joined);
        $this->assertSame([1, 2], $first->value());
        $this->assertSame([3, 4], $second->value());
    }

    #[Test]
    public function composesWithItself(): void
    {
        $this->assertSame(
            [1, 2, 3, 4],
            (new Joined(
                new Joined(new ListOf(1), new ListOf(2)),
                new Joined(new ListOf(3), new ListOf(4)),
            ))->value(),
        );
    }
}
