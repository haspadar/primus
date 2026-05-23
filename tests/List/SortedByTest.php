<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiFuncOf;
use Primus\List\ListOf;
use Primus\List\SortedBy;

final class SortedByTest extends TestCase
{
    #[Test]
    public function exposesEmptyListAsEmpty(): void
    {
        $this->assertSame(
            [],
            (new SortedBy(
                new ListOf(),
                new BiFuncOf(static fn(mixed $left, mixed $right): int => $left <=> $right),
            ))->value(),
        );
    }

    #[Test]
    public function ordersByComparatorResult(): void
    {
        $this->assertSame(
            ['pi', 'alpha', 'gamma'],
            (new SortedBy(
                new ListOf('alpha', 'pi', 'gamma'),
                new BiFuncOf(static fn(string $left, string $right): int
                    => strlen($left) <=> strlen($right)),
            ))->value(),
        );
    }

    #[Test]
    public function supportsDescendingComparator(): void
    {
        $this->assertSame(
            [5, 4, 3, 2, 1],
            (new SortedBy(
                new ListOf(3, 1, 4, 5, 2),
                new BiFuncOf(static fn(int $left, int $right): int => $right <=> $left),
            ))->value(),
        );
    }

    #[Test]
    public function preservesItemsConsideredEqualByComparator(): void
    {
        $this->assertSame(
            ['k', 'ab', 'cd', 'efg', 'hij'],
            (new SortedBy(
                new ListOf('ab', 'efg', 'cd', 'hij', 'k'),
                new BiFuncOf(static fn(string $left, string $right): int
                    => strlen($left) <=> strlen($right)),
            ))->value(),
        );
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $sorted = new SortedBy(
            new ListOf(3, 1, 2),
            new BiFuncOf(static fn(int $left, int $right): int => $left <=> $right),
        );
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
            new SortedBy(
                new ListOf(3, 1, 4, 5, 2),
                new BiFuncOf(static fn(int $left, int $right): int => $left <=> $right),
            ),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new ListOf(3, 1, 2);
        $sorted = new SortedBy(
            $source,
            new BiFuncOf(static fn(int $left, int $right): int => $left <=> $right),
        );
        $sorted->value();
        iterator_to_array($sorted);
        $this->assertSame([3, 1, 2], $source->value());
    }

    #[Test]
    public function ofListFactoryAgreesWithPrimaryConstructor(): void
    {
        $list = new ListOf(3, 1, 2);
        $order = new BiFuncOf(static fn(int $left, int $right): int => $left <=> $right);

        self::assertSame(
            (new SortedBy($list, $order))->value(),
            SortedBy::ofList($list, $order)->value(),
        );
    }
}
