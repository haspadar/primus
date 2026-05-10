<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use Generator;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\List\List_;
use Primus\List\Unique;

final class UniqueTest extends TestCase
{
    #[Test]
    public function dropsRepeatedValuesKeepingFirstOccurrence(): void
    {
        $this->assertSame(
            [1, 2, 3],
            (new Unique(new ListOf(1, 2, 1, 3, 2, 1)))->value(),
        );
    }

    #[Test]
    public function preservesRelativeOrderOfFirstOccurrences(): void
    {
        $this->assertSame(
            ['c', 'a', 'b'],
            (new Unique(new ListOf('c', 'a', 'c', 'b', 'a')))->value(),
        );
    }

    #[Test]
    public function returnsSequentialKeysStartingAtZero(): void
    {
        $this->assertSame(
            [0, 1, 2],
            array_keys((new Unique(new ListOf('x', 'y', 'x', 'z')))->value()),
        );
    }

    #[Test]
    public function distinguishesValuesByStrictType(): void
    {
        $this->assertSame(
            [0, '0', false],
            (new Unique(new ListOf(0, '0', false, 0, '0', false)))->value(),
        );
    }

    #[Test]
    public function leavesEmptyListEmpty(): void
    {
        $this->assertSame(
            [],
            (new Unique(new ListOf()))->value(),
        );
    }

    #[Test]
    public function leavesAlreadyUniqueListUnchanged(): void
    {
        $this->assertSame(
            [1, 2, 3, 4],
            (new Unique(new ListOf(1, 2, 3, 4)))->value(),
        );
    }

    #[Test]
    public function iteratesYieldingDeduplicatedValues(): void
    {
        $collected = [];
        foreach (new Unique(new ListOf(1, 1, 2, 2, 3)) as $value) {
            $collected[] = $value;
        }
        $this->assertSame([1, 2, 3], $collected);
    }

    #[Test]
    public function reportsCountOfDistinctValues(): void
    {
        $this->assertCount(3, new Unique(new ListOf(1, 1, 2, 3, 3, 2)));
    }

    #[Test]
    public function defersOriginValueResolutionUntilValueIsCalled(): void
    {
        $origin = new class () implements List_ {
            public function value(): array
            {
                throw new LogicException('value() must not be called by Unique constructor');
            }

            public function count(): int
            {
                return 0;
            }

            public function getIterator(): Generator
            {
                yield from [];
            }
        };

        new Unique($origin); // NOSONAR — instantiation is the subject under test for the lazy contract

        $this->expectNotToPerformAssertions();
    }
}
