<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\DiffAssoc;
use Primus\Map\MapOf;

final class DiffAssocTest extends TestCase
{
    #[Test]
    public function dropsPairsWithSameKeyAndStrictlyEqualValue(): void
    {
        $this->assertSame(
            ['c' => 3],
            (new DiffAssoc(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 1, 'b' => 2]),
            ))->value(),
        );
    }

    #[Test]
    public function keepsPairsWithSameKeyButDifferentValue(): void
    {
        $this->assertSame(
            ['b' => 2, 'c' => 3],
            (new DiffAssoc(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 1, 'b' => 99]),
            ))->value(),
        );
    }

    #[Test]
    public function subtractsAcrossMultipleSources(): void
    {
        $this->assertSame(
            ['c' => 3],
            (new DiffAssoc(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 1]),
                new MapOf(['b' => 2]),
            ))->value(),
        );
    }

    #[Test]
    public function distinguishesValuesByStrictType(): void
    {
        $this->assertSame(
            ['a' => 0],
            (new DiffAssoc(
                new MapOf(['a' => 0]),
                new MapOf(['a' => '0']),
            ))->value(),
        );
    }

    #[Test]
    public function preservesOriginalKeysOfKeptPairs(): void
    {
        $this->assertSame(
            ['b', 'c'],
            array_keys((new DiffAssoc(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 1]),
            ))->value()),
        );
    }

    #[Test]
    public function preservesRelativeOrderOfKeptPairs(): void
    {
        $this->assertSame(
            ['c' => 3, 'a' => 1, 'b' => 2],
            (new DiffAssoc(
                new MapOf(['c' => 3, 'x' => 9, 'a' => 1, 'y' => 8, 'b' => 2]),
                new MapOf(['x' => 9, 'y' => 8]),
            ))->value(),
        );
    }

    #[Test]
    public function emptyFirstOriginProducesEmptyResult(): void
    {
        $this->assertSame(
            [],
            (new DiffAssoc(
                new MapOf([]),
                new MapOf(['a' => 1]),
            ))->value(),
        );
    }

    #[Test]
    public function withoutOtherMapsKeepsAllPairs(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2],
            (new DiffAssoc(new MapOf(['a' => 1, 'b' => 2])))->value(),
        );
    }

    #[Test]
    public function iteratesYieldingKeptPairsWithKeys(): void
    {
        $collected = [];
        foreach (new DiffAssoc(
            new MapOf(['a' => 1, 'b' => 2]),
            new MapOf(['a' => 1]),
        ) as $key => $value) {
            $collected[$key] = $value;
        }
        $this->assertSame(['b' => 2], $collected);
    }

    #[Test]
    public function reportsCountOfKeptPairs(): void
    {
        $this->assertCount(
            2,
            new DiffAssoc(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['a' => 1]),
            ),
        );
    }

    #[Test]
    public function ofMapsFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2, 'c' => 3]);
        $excluded = new MapOf(['a' => 1, 'b' => 99]);

        self::assertSame(
            (new DiffAssoc($source, $excluded))->value(),
            DiffAssoc::ofMaps($source, $excluded)->value(),
        );
    }

    #[Test]
    public function ofMapsFactoryAgreesWithPrimaryConstructorWithoutExcluded(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2]);

        self::assertSame(
            (new DiffAssoc($source))->value(),
            DiffAssoc::ofMaps($source)->value(),
        );
    }
}
