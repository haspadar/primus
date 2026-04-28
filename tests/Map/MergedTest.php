<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Map\Mapped;
use Primus\Map\MapOf;
use Primus\Map\Merged;

final class MergedTest extends TestCase
{
    #[Test]
    public function combinesAllPairsWithoutCollision(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2, 'c' => 3],
            (new Merged(
                new MapOf(['a' => 1]),
                new MapOf(['b' => 2, 'c' => 3]),
            ))->value(),
        );
    }

    #[Test]
    public function laterSourceWinsOnKeyCollision(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 99, 'c' => 3],
            (new Merged(
                new MapOf(['a' => 1, 'b' => 2]),
                new MapOf(['b' => 99, 'c' => 3]),
            ))->value(),
        );
    }

    #[Test]
    public function lastOfThreeWinsOnTripleCollision(): void
    {
        $this->assertSame(
            ['k' => 'third'],
            (new Merged(
                new MapOf(['k' => 'first']),
                new MapOf(['k' => 'second']),
                new MapOf(['k' => 'third']),
            ))->value(),
        );
    }

    #[Test]
    public function emptyMergeYieldsEmpty(): void
    {
        $this->assertCount(0, new Merged());
    }

    #[Test]
    public function leavesSourcesUntouchedAfterReading(): void
    {
        $first = new MapOf(['a' => 1]);
        $second = new MapOf(['a' => 2, 'b' => 3]);
        $merged = new Merged($first, $second);
        $merged->value();
        iterator_to_array($merged);
        $this->assertSame(['a' => 1], $first->value());
        $this->assertSame(['a' => 2, 'b' => 3], $second->value());
    }

    #[Test]
    public function iteratesPreservingKeys(): void
    {
        $collected = [];
        foreach (new Merged(new MapOf(['a' => 1]), new MapOf(['b' => 2])) as $key => $value) {
            $collected[$key] = $value;
        }
        $this->assertSame(['a' => 1, 'b' => 2], $collected);
    }

    #[Test]
    public function composesWithMapped(): void
    {
        $this->assertSame(
            ['a' => 10, 'b' => 200, 'c' => 30],
            (new Merged(
                new Mapped(
                    new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                    new FuncOf(static fn (int $v): int => $v * 10),
                ),
                new MapOf(['b' => 200]),
            ))->value(),
        );
    }
}
