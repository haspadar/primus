<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\MapOf;
use Primus\Map\Unique;

final class UniqueTest extends TestCase
{
    #[Test]
    public function dropsRepeatedValuesKeepingFirstEntry(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2, 'd' => 3],
            (new Unique(new MapOf(['a' => 1, 'b' => 2, 'c' => 1, 'd' => 3, 'e' => 2])))->value(),
        );
    }

    #[Test]
    public function preservesOriginalKeysOfKeptEntries(): void
    {
        $this->assertSame(
            ['x', 'y'],
            array_keys((new Unique(new MapOf(['x' => 'a', 'y' => 'b', 'z' => 'a'])))->value()),
        );
    }

    #[Test]
    public function preservesRelativeOrderOfFirstOccurrences(): void
    {
        $this->assertSame(
            ['c' => 1, 'a' => 2, 'b' => 3],
            (new Unique(new MapOf(['c' => 1, 'a' => 2, 'd' => 1, 'b' => 3, 'e' => 2])))->value(),
        );
    }

    #[Test]
    public function distinguishesValuesByStrictType(): void
    {
        $this->assertSame(
            ['a' => 0, 'b' => '0', 'c' => false],
            (new Unique(new MapOf(['a' => 0, 'b' => '0', 'c' => false, 'd' => 0])))->value(),
        );
    }

    #[Test]
    public function leavesEmptyMapEmpty(): void
    {
        $this->assertSame(
            [],
            (new Unique(new MapOf([])))->value(),
        );
    }

    #[Test]
    public function leavesAlreadyUniqueMapUnchanged(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2, 'c' => 3],
            (new Unique(new MapOf(['a' => 1, 'b' => 2, 'c' => 3])))->value(),
        );
    }

    #[Test]
    public function iteratesYieldingDeduplicatedEntriesWithKeys(): void
    {
        $collected = [];
        foreach (new Unique(new MapOf(['a' => 1, 'b' => 1, 'c' => 2])) as $key => $value) {
            $collected[$key] = $value;
        }
        $this->assertSame(['a' => 1, 'c' => 2], $collected);
    }

    #[Test]
    public function reportsCountOfDistinctValues(): void
    {
        $this->assertCount(2, new Unique(new MapOf(['a' => 1, 'b' => 1, 'c' => 2])));
    }

    #[Test]
    public function ofMapFactoryAgreesWithPrimaryConstructor(): void
    {
        $map = new MapOf(['a' => 1, 'b' => 1, 'c' => 2]);

        self::assertSame(
            (new Unique($map))->value(),
            Unique::ofMap($map)->value(),
        );
    }
}
