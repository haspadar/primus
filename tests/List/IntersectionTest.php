<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\Intersection;
use Primus\List\ListOf;

final class IntersectionTest extends TestCase
{
    #[Test]
    public function keepsValuesPresentInOtherList(): void
    {
        $this->assertSame(
            [2, 3],
            (new Intersection(
                new ListOf(1, 2, 3, 4),
                new ListOf(2, 3, 5),
            ))->value(),
        );
    }

    #[Test]
    public function requiresPresenceInEveryOtherSource(): void
    {
        $this->assertSame(
            [3, 5],
            (new Intersection(
                new ListOf(1, 2, 3, 4, 5),
                new ListOf(2, 3, 5),
                new ListOf(3, 4, 5),
                new ListOf(1, 3, 5),
            ))->value(),
        );
    }

    #[Test]
    public function dropsValueMissingInAnyOtherSource(): void
    {
        $this->assertSame(
            [2],
            (new Intersection(
                new ListOf(1, 2, 3),
                new ListOf(1, 2, 3),
                new ListOf(2),
            ))->value(),
        );
    }

    #[Test]
    public function distinguishesValuesByStrictType(): void
    {
        $this->assertSame(
            [0],
            (new Intersection(
                new ListOf(0, '0', false),
                new ListOf(0),
            ))->value(),
        );
    }

    #[Test]
    public function preservesDuplicatesOfKeptValues(): void
    {
        $this->assertSame(
            ['a', 'a', 'c'],
            (new Intersection(
                new ListOf('a', 'b', 'a', 'c'),
                new ListOf('a', 'c'),
            ))->value(),
        );
    }

    #[Test]
    public function preservesRelativeOrderOfKeptValues(): void
    {
        $this->assertSame(
            ['c', 'a', 'b'],
            (new Intersection(
                new ListOf('c', 'x', 'a', 'y', 'b'),
                new ListOf('a', 'b', 'c'),
            ))->value(),
        );
    }

    #[Test]
    public function returnsSequentialKeysStartingAtZero(): void
    {
        $this->assertSame(
            [0, 1],
            array_keys((new Intersection(
                new ListOf('a', 'b', 'c'),
                new ListOf('a', 'c'),
            ))->value()),
        );
    }

    #[Test]
    public function emptyFirstOriginProducesEmptyResult(): void
    {
        $this->assertSame(
            [],
            (new Intersection(
                new ListOf(),
                new ListOf(1, 2, 3),
            ))->value(),
        );
    }

    #[Test]
    public function withoutOtherListsReturnsFirstOriginAsIs(): void
    {
        $this->assertSame(
            [1, 2, 3],
            (new Intersection(new ListOf(1, 2, 3)))->value(),
        );
    }

    #[Test]
    public function iteratesYieldingKeptValues(): void
    {
        $collected = [];
        foreach (new Intersection(new ListOf(1, 2, 3), new ListOf(2, 3)) as $value) {
            $collected[] = $value;
        }
        $this->assertSame([2, 3], $collected);
    }

    #[Test]
    public function reportsCountOfKeptValues(): void
    {
        $this->assertCount(
            2,
            new Intersection(new ListOf(1, 2, 3), new ListOf(2, 3, 4)),
        );
    }

    #[Test]
    public function ofListsFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = new ListOf(1, 2, 3, 4);
        $required = new ListOf(2, 3, 5);

        self::assertSame(
            (new Intersection($source, $required))->value(),
            Intersection::ofLists($source, $required)->value(),
        );
    }

    #[Test]
    public function ofListsFactoryAgreesWithPrimaryConstructorWithoutOthers(): void
    {
        $source = new ListOf(1, 2, 3);

        self::assertSame(
            (new Intersection($source))->value(),
            Intersection::ofLists($source)->value(),
        );
    }
}
