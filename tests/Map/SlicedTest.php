<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\MapOf;
use Primus\Map\Sliced;

final class SlicedTest extends TestCase
{
    #[Test]
    public function takesEntriesFromGivenOffsetWithLength(): void
    {
        $this->assertSame(
            ['b' => 2, 'c' => 3],
            (new Sliced(new MapOf(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]), 1, 2))->value(),
        );
    }

    #[Test]
    public function negativeOffsetCountsFromTheEnd(): void
    {
        $this->assertSame(
            ['c' => 3, 'd' => 4],
            (new Sliced(new MapOf(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]), -2))->value(),
        );
    }

    #[Test]
    public function omittedLengthExtendsToTheEnd(): void
    {
        $this->assertSame(
            ['c' => 3, 'd' => 4],
            (new Sliced(new MapOf(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]), 2))->value(),
        );
    }

    #[Test]
    public function negativeLengthStopsBeforeTheEnd(): void
    {
        $this->assertSame(
            ['b' => 2, 'c' => 3],
            (new Sliced(new MapOf(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]), 1, -1))->value(),
        );
    }

    #[Test]
    public function offsetBeyondEndProducesEmptyMap(): void
    {
        $this->assertSame(
            [],
            (new Sliced(new MapOf(['a' => 1, 'b' => 2]), 10))->value(),
        );
    }

    #[Test]
    public function nonPositiveLengthProducesEmptyMap(): void
    {
        $this->assertSame(
            [],
            (new Sliced(new MapOf(['a' => 1, 'b' => 2]), 0, 0))->value(),
        );
    }

    #[Test]
    public function preservesOriginalKeys(): void
    {
        $this->assertSame(
            ['b', 'c'],
            array_keys((new Sliced(new MapOf(['a' => 1, 'b' => 2, 'c' => 3]), 1))->value()),
        );
    }

    #[Test]
    public function iteratesYieldingSlicedEntriesWithKeys(): void
    {
        $collected = [];
        foreach (new Sliced(new MapOf(['a' => 1, 'b' => 2, 'c' => 3]), 1, 1) as $key => $value) {
            $collected[$key] = $value;
        }
        $this->assertSame(['b' => 2], $collected);
    }

    #[Test]
    public function reportsCountOfSlicedEntries(): void
    {
        $this->assertCount(
            2,
            new Sliced(new MapOf(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]), 1, 2),
        );
    }
}
