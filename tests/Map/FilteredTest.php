<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Map\Filtered;
use Primus\Map\Mapped;
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
                new FuncOf(static fn (int $v): bool => $v > 10),
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
                new FuncOf(static fn (int $v): bool => $v > 5),
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
                new FuncOf(static fn (int $v): bool => $v > 100),
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
                new FuncOf(static fn (int $v): bool => $v % 2 === 0),
            ),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2, 'c' => 3]);
        $filtered = new Filtered(
            $source,
            new FuncOf(static fn (int $v): bool => $v > 1),
        );
        $filtered->value();
        $this->assertSame(['b' => 2, 'c' => 3], iterator_to_array($filtered));
        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], $source->value());
    }

    #[Test]
    public function composesWithMapped(): void
    {
        $this->assertSame(
            ['b' => 200, 'c' => 300],
            (new Filtered(
                new Mapped(
                    new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                    new FuncOf(static fn (int $v): int => $v * 100),
                ),
                new FuncOf(static fn (int $v): bool => $v > 100),
            ))->value(),
        );
    }

    #[Test]
    public function yieldsNothingWhenSourceIsEmpty(): void
    {
        $this->assertCount(
            0,
            new Filtered(
                new MapOf([]),
                new FuncOf(static fn (int $v): bool => $v > 0),
            ),
        );
    }

    #[Test]
    public function ofMapFactoryAgreesWithPrimaryConstructor(): void
    {
        $map = new MapOf(['a' => 10, 'b' => 5, 'c' => 40]);
        $selector = new FuncOf(static fn(int $v): bool => $v > 10);

        self::assertSame(
            (new Filtered($map, $selector))->value(),
            Filtered::ofMap($map, $selector)->value(),
        );
    }
}
