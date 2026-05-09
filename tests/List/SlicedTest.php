<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\List\Sliced;

final class SlicedTest extends TestCase
{
    #[Test]
    public function takesElementsFromGivenOffsetWithLength(): void
    {
        $this->assertSame(
            [2, 3, 4],
            (new Sliced(new ListOf(1, 2, 3, 4, 5), 1, 3))->value(),
        );
    }

    #[Test]
    public function negativeOffsetCountsFromTheEnd(): void
    {
        $this->assertSame(
            [4, 5],
            (new Sliced(new ListOf(1, 2, 3, 4, 5), -2))->value(),
        );
    }

    #[Test]
    public function omittedLengthExtendsToTheEnd(): void
    {
        $this->assertSame(
            [3, 4, 5],
            (new Sliced(new ListOf(1, 2, 3, 4, 5), 2))->value(),
        );
    }

    #[Test]
    public function negativeLengthStopsBeforeTheEnd(): void
    {
        $this->assertSame(
            [2, 3],
            (new Sliced(new ListOf(1, 2, 3, 4, 5), 1, -2))->value(),
        );
    }

    #[Test]
    public function offsetBeyondEndProducesEmptyList(): void
    {
        $this->assertSame(
            [],
            (new Sliced(new ListOf(1, 2, 3), 10))->value(),
        );
    }

    #[Test]
    public function nonPositiveLengthProducesEmptyList(): void
    {
        $this->assertSame(
            [],
            (new Sliced(new ListOf(1, 2, 3), 0, 0))->value(),
        );
    }

    #[Test]
    public function returnsSequentialKeysStartingAtZero(): void
    {
        $this->assertSame(
            [0, 1, 2],
            array_keys((new Sliced(new ListOf('a', 'b', 'c', 'd'), 1, 3))->value()),
        );
    }

    #[Test]
    public function iteratesYieldingSlicedElements(): void
    {
        $collected = [];
        foreach (new Sliced(new ListOf(1, 2, 3, 4, 5), 1, 2) as $value) {
            $collected[] = $value;
        }
        $this->assertSame([2, 3], $collected);
    }
}
