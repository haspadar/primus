<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\List\Reversed;
use Primus\List\Sorted;

final class SortedTest extends TestCase
{
    #[Test]
    public function exposesEmptyListAsEmpty(): void
    {
        $this->assertSame([], (new Sorted(new ListOf()))->value());
    }

    #[Test]
    public function ordersIntegersAscending(): void
    {
        $this->assertSame(
            [1, 2, 3, 4, 5],
            (new Sorted(new ListOf(3, 1, 4, 5, 2)))->value(),
        );
    }

    #[Test]
    public function ordersStringsLexicographically(): void
    {
        $this->assertSame(
            ['alpha', 'bravo', 'charlie'],
            (new Sorted(new ListOf('charlie', 'alpha', 'bravo')))->value(),
        );
    }

    #[Test]
    public function preservesEqualItems(): void
    {
        $this->assertSame(
            [1, 1, 2, 2, 3],
            (new Sorted(new ListOf(2, 1, 3, 2, 1)))->value(),
        );
    }

    #[Test]
    public function reindexesKeysSequentiallyFromZero(): void
    {
        $this->assertSame(
            [0 => 1, 1 => 2, 2 => 3],
            (new Sorted(new ListOf(3, 1, 2)))->value(),
        );
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $sorted = new Sorted(new ListOf(3, 1, 2));
        $this->assertSame(
            $sorted->value(),
            iterator_to_array($sorted),
        );
    }

    #[Test]
    public function countsSourceItems(): void
    {
        $this->assertCount(
            5,
            new Sorted(new ListOf(3, 1, 4, 5, 2)),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new ListOf(3, 1, 2);
        $sorted = new Sorted($source);
        $sorted->value();
        iterator_to_array($sorted);
        $this->assertSame([3, 1, 2], $source->value());
    }

    #[Test]
    public function composesWithReversedToProduceDescending(): void
    {
        $this->assertSame(
            [5, 4, 3, 2, 1],
            (new Reversed(new Sorted(new ListOf(3, 1, 4, 5, 2))))->value(),
        );
    }
}
