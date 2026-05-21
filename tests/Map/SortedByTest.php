<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiFuncOf;
use Primus\Map\MapOf;
use Primus\Map\SortedBy;

final class SortedByTest extends TestCase
{
    #[Test]
    public function exposesEmptyMapAsEmpty(): void
    {
        $this->assertSame(
            [],
            (new SortedBy(
                new MapOf([]),
                new BiFuncOf(static fn(mixed $left, mixed $right): int => $left <=> $right),
            ))->value(),
        );
    }

    #[Test]
    public function ordersByComparatorResultAndPreservesKeys(): void
    {
        $this->assertSame(
            ['y' => 'pi', 'x' => 'alpha', 'z' => 'gamma'],
            (new SortedBy(
                new MapOf(['x' => 'alpha', 'y' => 'pi', 'z' => 'gamma']),
                new BiFuncOf(static fn(string $left, string $right): int
                    => strlen($left) <=> strlen($right)),
            ))->value(),
        );
    }

    #[Test]
    public function supportsDescendingComparator(): void
    {
        $this->assertSame(
            ['d' => 5, 'c' => 4, 'a' => 3, 'e' => 2, 'b' => 1],
            (new SortedBy(
                new MapOf(['a' => 3, 'b' => 1, 'c' => 4, 'd' => 5, 'e' => 2]),
                new BiFuncOf(static fn(int $left, int $right): int => $right <=> $left),
            ))->value(),
        );
    }

    #[Test]
    public function preservesPairsConsideredEqualByComparator(): void
    {
        $this->assertSame(
            ['e' => 'k', 'a' => 'ab', 'c' => 'cd', 'b' => 'efg', 'd' => 'hij'],
            (new SortedBy(
                new MapOf(['a' => 'ab', 'b' => 'efg', 'c' => 'cd', 'd' => 'hij', 'e' => 'k']),
                new BiFuncOf(static fn(string $left, string $right): int
                    => strlen($left) <=> strlen($right)),
            ))->value(),
        );
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $sorted = new SortedBy(
            new MapOf(['b' => 3, 'a' => 1, 'c' => 2]),
            new BiFuncOf(static fn(int $left, int $right): int => $left <=> $right),
        );
        $this->assertSame(
            $sorted->value(),
            iterator_to_array($sorted),
        );
    }

    #[Test]
    public function countsSourcePairs(): void
    {
        $this->assertCount(
            5,
            new SortedBy(
                new MapOf(['a' => 3, 'b' => 1, 'c' => 4, 'd' => 5, 'e' => 2]),
                new BiFuncOf(static fn(int $left, int $right): int => $left <=> $right),
            ),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new MapOf(['b' => 3, 'a' => 1, 'c' => 2]);
        $sorted = new SortedBy(
            $source,
            new BiFuncOf(static fn(int $left, int $right): int => $left <=> $right),
        );
        $sorted->value();
        iterator_to_array($sorted);
        $this->assertSame(['b' => 3, 'a' => 1, 'c' => 2], $source->value());
    }
}
