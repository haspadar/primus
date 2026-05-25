<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\IntersectAssoc;
use Primus\Map\MapOf;

final class IntersectAssocTest extends TestCase
{
    #[Test]
    public function keepsPairsPresentInOtherMap(): void
    {
        $this->assertSame(
            ['a' => 1, 'c' => 3],
            (new IntersectAssoc(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 1, 'b' => 99, 'c' => 3]),
            ))->value(),
        );
    }

    #[Test]
    public function requiresPresenceInEveryOtherSource(): void
    {
        $this->assertSame(
            ['c' => 3],
            (new IntersectAssoc(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 1, 'c' => 3]),
                new MapOf(['b' => 2, 'c' => 3]),
                new MapOf(['c' => 3, 'd' => 4]),
            ))->value(),
        );
    }

    #[Test]
    public function dropsPairWithSameKeyButDifferentValue(): void
    {
        $this->assertSame(
            ['a' => 1],
            (new IntersectAssoc(
                new MapOf(['a' => 1, 'b' => 2]),
                new MapOf(['a' => 1, 'b' => 99]),
            ))->value(),
        );
    }

    #[Test]
    public function dropsPairWhenAnyOtherSourceLacksTheKey(): void
    {
        $this->assertSame(
            ['a' => 1],
            (new IntersectAssoc(
                new MapOf(['a' => 1, 'b' => 2]),
                new MapOf(['a' => 1, 'b' => 2]),
                new MapOf(['a' => 1]),
            ))->value(),
        );
    }

    #[Test]
    public function distinguishesValuesByStrictType(): void
    {
        $this->assertSame(
            [],
            (new IntersectAssoc(
                new MapOf(['a' => 0]),
                new MapOf(['a' => '0']),
            ))->value(),
        );
    }

    #[Test]
    public function preservesOriginalKeysOfKeptPairs(): void
    {
        $this->assertSame(
            ['a', 'c'],
            array_keys((new IntersectAssoc(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 1, 'c' => 3]),
            ))->value()),
        );
    }

    #[Test]
    public function preservesRelativeOrderOfKeptPairs(): void
    {
        $this->assertSame(
            ['c' => 3, 'a' => 1, 'b' => 2],
            (new IntersectAssoc(
                new MapOf(['c' => 3, 'x' => 9, 'a' => 1, 'y' => 8, 'b' => 2]),
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
            ))->value(),
        );
    }

    #[Test]
    public function emptyFirstOriginProducesEmptyResult(): void
    {
        $this->assertSame(
            [],
            (new IntersectAssoc(
                new MapOf([]),
                new MapOf(['a' => 1]),
            ))->value(),
        );
    }

    #[Test]
    public function withoutOtherMapsReturnsFirstOriginAsIs(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2],
            (new IntersectAssoc(new MapOf(['a' => 1, 'b' => 2])))->value(),
        );
    }

    #[Test]
    public function iteratesYieldingKeptPairsWithKeys(): void
    {
        $collected = [];
        foreach (new IntersectAssoc(
            new MapOf(['a' => 1, 'b' => 2]),
            new MapOf(['a' => 1, 'b' => 2]),
        ) as $key => $value) {
            $collected[$key] = $value;
        }
        $this->assertSame(['a' => 1, 'b' => 2], $collected);
    }

    #[Test]
    public function reportsCountOfKeptPairs(): void
    {
        $this->assertCount(
            2,
            new IntersectAssoc(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 1, 'b' => 2]),
            ),
        );
    }

    #[Test]
    public function ofMapsFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2, 'c' => 3]);
        $matched = new MapOf(['a' => 1, 'b' => 99, 'c' => 3]);

        self::assertSame(
            (new IntersectAssoc($source, $matched))->value(),
            IntersectAssoc::ofMaps($source, $matched)->value(),
        );
    }

    #[Test]
    public function ofMapsFactoryAgreesWithPrimaryConstructorWithoutMatched(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2]);

        self::assertSame(
            (new IntersectAssoc($source))->value(),
            IntersectAssoc::ofMaps($source)->value(),
        );
    }
}
