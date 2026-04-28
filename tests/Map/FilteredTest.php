<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\PredicateOf;
use Primus\Map\Filtered;
use Primus\Map\MapOf;

final class FilteredTest extends TestCase
{
    #[Test]
    public function yieldsPairsWithMatchingValues(): void
    {
        $this->assertSame(
            ['c' => 40, 'e' => 50],
            (new Filtered(
                new MapOf(['a' => 10, 'b' => 5, 'c' => 40, 'd' => 3, 'e' => 50]),
                new PredicateOf(static fn (int $v): bool => $v > 10),
            ))->value(),
        );
    }

    #[Test]
    public function preservesRelativeOrderAndKeys(): void
    {
        $this->assertSame(
            ['banana' => 6, 'cherry' => 6],
            (new Filtered(
                new MapOf(['apple' => 5, 'banana' => 6, 'cherry' => 6]),
                new PredicateOf(static fn (int $v): bool => $v > 5),
            ))->value(),
        );
    }

    #[Test]
    public function yieldsNothingWhenNoneMatch(): void
    {
        $this->assertCount(
            0,
            new Filtered(
                new MapOf(['a' => 1, 'b' => 2]),
                new PredicateOf(static fn (int $v): bool => $v > 100),
            ),
        );
    }

    #[Test]
    public function countReflectsMatchedPairs(): void
    {
        $this->assertCount(
            2,
            new Filtered(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]),
                new PredicateOf(static fn (int $v): bool => $v % 2 === 0),
            ),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2, 'c' => 3]);
        $filtered = new Filtered(
            $source,
            new PredicateOf(static fn (int $v): bool => $v > 1),
        );
        $filtered->value();
        iterator_to_array($filtered);
        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], $source->value());
    }
}
