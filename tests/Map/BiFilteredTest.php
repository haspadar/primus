<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiFuncOf;
use Primus\Map\BiFiltered;
use Primus\Map\BiMapped;
use Primus\Map\MapOf;

final class BiFilteredTest extends TestCase
{
    #[Test]
    public function yieldsPairsWithMatchingKeysAndValues(): void
    {
        $this->assertSame(
            ['critical' => 9, 'major' => 7],
            (new BiFiltered(
                new MapOf(['minor' => 2, 'critical' => 9, 'major' => 7, 'trivial' => 1]),
                new BiFuncOf(static fn (string $key, int $value): bool => strlen($key) >= 5 && $value > 5),
            ))->value(),
        );
    }

    #[Test]
    public function preservesRelativeOrderAndKeys(): void
    {
        $this->assertSame(
            ['east' => 12, 'west' => 14],
            (new BiFiltered(
                new MapOf(['north' => 8, 'east' => 12, 'west' => 14]),
                new BiFuncOf(static fn (string $key, int $value): bool => strlen($key) === 4 && $value > 10),
            ))->value(),
        );
    }

    #[Test]
    public function yieldsNothingWhenNoneMatch(): void
    {
        $filtered = new BiFiltered(
            new MapOf(['draft' => 2, 'queued' => 4]),
            new BiFuncOf(
                static fn (string $key, int $value): bool => str_starts_with($key, 'done') && $value > 5
            ),
        );
        $this->assertCount(0, $filtered);
        $this->assertSame([], iterator_to_array($filtered));
    }

    #[Test]
    public function countReflectsMatchedPairs(): void
    {
        $this->assertCount(
            2,
            new BiFiltered(
                new MapOf(['home' => 1, 'work' => 2, 'park' => 3]),
                new BiFuncOf(static fn (string $key, int $value): bool => strlen($key) === 4 && $value > 1),
            ),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new MapOf(['admin' => 10, 'guest' => 1, 'editor' => 6]);
        $filtered = new BiFiltered(
            $source,
            new BiFuncOf(static fn (string $key, int $value): bool => strlen($key) > 5 && $value > 5),
        );
        $filtered->value();
        $this->assertSame(['editor' => 6], iterator_to_array($filtered));
        $this->assertSame(['admin' => 10, 'guest' => 1, 'editor' => 6], $source->value());
    }

    #[Test]
    public function composesWithBiMapped(): void
    {
        $this->assertSame(
            ['open' => 'open:3'],
            (new BiFiltered(
                new BiMapped(
                    new MapOf(['open' => 3, 'closed' => 9]),
                    new BiFuncOf(static fn (string $key, int $value): string => "$key:$value"),
                ),
                new BiFuncOf(static fn (string $key, string $value): bool => $key === 'open' && $value === 'open:3'),
            ))->value(),
        );
    }

    #[Test]
    public function yieldsNothingWhenSourceIsEmpty(): void
    {
        $filtered = new BiFiltered(
            new MapOf([]),
            new BiFuncOf(static fn (string $key, int $value): bool => strlen($key) > 1 && $value > 0),
        );
        $this->assertCount(0, $filtered);
        $this->assertSame([], iterator_to_array($filtered));
    }

    #[Test]
    public function ofMapFactoryAgreesWithPrimaryConstructor(): void
    {
        $map = new MapOf(['a' => 1, 'b' => 2, 'c' => 3]);
        $selector = new BiFuncOf(static fn(string $k, int $v): bool => $v > 1);

        self::assertSame(
            (new BiFiltered($map, $selector))->value(),
            BiFiltered::ofMap($map, $selector)->value(),
        );
    }
}
