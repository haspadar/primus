<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Map\Mapped;
use Primus\Map\MapOf;
use Primus\Map\NoNulls;

final class MappedTest extends TestCase
{
    #[Test]
    public function transformsEachValuePreservingKeys(): void
    {
        $this->assertSame(
            ['a' => 10, 'b' => 20, 'c' => 30],
            (new Mapped(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new FuncOf(static fn (int $v): int => $v * 10),
            ))->value(),
        );
    }

    #[Test]
    public function preservesCount(): void
    {
        $this->assertCount(
            3,
            new Mapped(
                new MapOf(['x' => 'a', 'y' => 'b', 'z' => 'c']),
                new FuncOf(static fn (string $v): string => strtoupper($v)),
            ),
        );
    }

    #[Test]
    public function iteratesOverTransformedPairs(): void
    {
        $collected = [];
        foreach (
            new Mapped(
                new MapOf(['k1' => 1, 'k2' => 2]),
                new FuncOf(static fn (int $v): int => $v + 100),
            ) as $key => $value
        ) {
            $collected[$key] = $value;
        }
        $this->assertSame(['k1' => 101, 'k2' => 102], $collected);
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2]);
        $mapped = new Mapped(
            $source,
            new FuncOf(static fn (int $v): int => $v * 5),
        );
        $mapped->value();
        iterator_to_array($mapped);
        $this->assertSame(['a' => 1, 'b' => 2], $source->value());
    }

    #[Test]
    public function composesWithNoNulls(): void
    {
        $this->assertSame(
            ['a' => 10, 'b' => 20],
            (new Mapped(
                new NoNulls(new MapOf(['a' => 1, 'b' => 2])),
                new FuncOf(static fn (int $v): int => $v * 10),
            ))->value(),
        );
    }
}
