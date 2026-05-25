<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\Intersect;
use Primus\Map\MapOf;

final class IntersectTest extends TestCase
{
    #[Test]
    public function returnsFirstSourceUntouchedWhenNoOtherSources(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2],
            (new Intersect(new MapOf(['a' => 1, 'b' => 2])))->value(),
        );
    }

    #[Test]
    public function keepsKeysSharedWithLaterSource(): void
    {
        $this->assertSame(
            ['b' => 2],
            (new Intersect(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['b' => 99]),
            ))->value(),
        );
    }

    #[Test]
    public function keepsKeysSharedWithEveryLaterSource(): void
    {
        $this->assertSame(
            ['c' => 3],
            (new Intersect(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['b' => 99, 'c' => 0]),
                new MapOf(['c' => 7, 'd' => 1]),
            ))->value(),
        );
    }

    #[Test]
    public function preservesFirstSourceValuesUnchanged(): void
    {
        $this->assertSame(
            ['b' => 2, 'c' => 3],
            (new Intersect(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['b' => 'replacement-ignored', 'c' => 'also-ignored']),
            ))->value(),
        );
    }

    #[Test]
    public function ignoresRequiredSourceValuesWhenSelectingPairs(): void
    {
        $this->assertSame(
            ['a' => 1],
            (new Intersect(
                new MapOf(['a' => 1, 'b' => 2]),
                new MapOf(['a' => 0]),
            ))->value(),
        );
    }

    #[Test]
    public function preservesFirstSourceIterationOrder(): void
    {
        $this->assertSame(
            ['c' => 3, 'a' => 1],
            (new Intersect(
                new MapOf(['c' => 3, 'b' => 2, 'a' => 1]),
                new MapOf(['a' => 0, 'c' => 0]),
            ))->value(),
        );
    }

    #[Test]
    public function distinguishesNumericStringKeyFromIntegerKey(): void
    {
        $this->assertSame(
            [1 => 'one'],
            (new Intersect(
                new MapOf([1 => 'one', '01' => 'leadingZero']),
                new MapOf([1 => 'shared-canonical-int-only']),
            ))->value(),
        );
    }

    #[Test]
    public function returnsEmptyWhenNoKeysShared(): void
    {
        $this->assertSame(
            [],
            (new Intersect(
                new MapOf(['a' => 1, 'b' => 2]),
                new MapOf(['c' => 0, 'd' => 0]),
            ))->value(),
        );
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $intersect = new Intersect(
            new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
            new MapOf(['b' => 0, 'c' => 0]),
        );
        $this->assertSame(
            $intersect->value(),
            iterator_to_array($intersect),
        );
    }

    #[Test]
    public function countsPairsAfterIntersection(): void
    {
        $this->assertCount(
            2,
            new Intersect(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 0, 'b' => 0]),
            ),
        );
    }

    #[Test]
    public function leavesSourcesUntouchedAfterReading(): void
    {
        $first = new MapOf(['a' => 1, 'b' => 2]);
        $required = new MapOf(['b' => 99]);
        $intersect = new Intersect($first, $required);
        $intersect->value();
        iterator_to_array($intersect);
        $this->assertSame(['a' => 1, 'b' => 2], $first->value());
        $this->assertSame(['b' => 99], $required->value());
    }

    #[Test]
    public function ofMapsFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2, 'c' => 3]);
        $pinned = new MapOf(['b' => 99, 'c' => 0]);

        self::assertSame(
            (new Intersect($source, $pinned))->value(),
            Intersect::ofMaps($source, $pinned)->value(),
        );
    }

    #[Test]
    public function ofMapsFactoryAgreesWithPrimaryConstructorWithoutPinned(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2]);

        self::assertSame(
            (new Intersect($source))->value(),
            Intersect::ofMaps($source)->value(),
        );
    }
}
