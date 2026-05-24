<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\Difference;
use Primus\List\ListOf;

final class DifferenceTest extends TestCase
{
    #[Test]
    public function keepsValuesAbsentFromOtherList(): void
    {
        $this->assertSame(
            [1, 3],
            (new Difference(
                new ListOf(1, 2, 3, 4),
                new ListOf(2, 4),
            ))->value(),
        );
    }

    #[Test]
    public function subtractsAcrossMultipleSources(): void
    {
        $this->assertSame(
            [3],
            (new Difference(
                new ListOf(1, 2, 3, 4, 5),
                new ListOf(1, 2),
                new ListOf(4, 5),
            ))->value(),
        );
    }

    #[Test]
    public function distinguishesValuesByStrictType(): void
    {
        $this->assertSame(
            [0, '0'],
            (new Difference(
                new ListOf(0, '0', 1),
                new ListOf(1),
            ))->value(),
        );
    }

    #[Test]
    public function preservesDuplicatesOfKeptValues(): void
    {
        $this->assertSame(
            ['a', 'a', 'c'],
            (new Difference(
                new ListOf('a', 'b', 'a', 'c'),
                new ListOf('b'),
            ))->value(),
        );
    }

    #[Test]
    public function preservesRelativeOrderOfKeptValues(): void
    {
        $this->assertSame(
            ['c', 'a', 'b'],
            (new Difference(
                new ListOf('c', 'x', 'a', 'y', 'b'),
                new ListOf('x', 'y'),
            ))->value(),
        );
    }

    #[Test]
    public function returnsSequentialKeysStartingAtZero(): void
    {
        $this->assertSame(
            [0, 1],
            array_keys((new Difference(
                new ListOf('a', 'b', 'c'),
                new ListOf('b'),
            ))->value()),
        );
    }

    #[Test]
    public function emptyFirstOriginProducesEmptyResult(): void
    {
        $this->assertSame(
            [],
            (new Difference(
                new ListOf(),
                new ListOf(1, 2, 3),
            ))->value(),
        );
    }

    #[Test]
    public function withoutOtherListsKeepsAllValues(): void
    {
        $this->assertSame(
            [1, 2, 3],
            (new Difference(new ListOf(1, 2, 3)))->value(),
        );
    }

    #[Test]
    public function iteratesYieldingKeptValues(): void
    {
        $collected = [];
        foreach (new Difference(new ListOf(1, 2, 3), new ListOf(2)) as $value) {
            $collected[] = $value;
        }
        $this->assertSame([1, 3], $collected);
    }

    #[Test]
    public function reportsCountOfKeptValues(): void
    {
        $this->assertCount(
            2,
            new Difference(new ListOf(1, 2, 3), new ListOf(2)),
        );
    }

    #[Test]
    public function ofListsFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = new ListOf(1, 2, 3, 4);
        $excluded = new ListOf(2, 4);

        self::assertSame(
            (new Difference($source, $excluded))->value(),
            Difference::ofLists($source, $excluded)->value(),
        );
    }

    #[Test]
    public function ofListsFactoryAgreesWithPrimaryConstructorWithoutExcluded(): void
    {
        $source = new ListOf(1, 2, 3);

        self::assertSame(
            (new Difference($source))->value(),
            Difference::ofLists($source)->value(),
        );
    }
}
