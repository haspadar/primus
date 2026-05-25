<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\MapOf;

final class MapOfTest extends TestCase
{
    #[Test]
    public function exposesPairsAsArray(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2],
            (new MapOf(['a' => 1, 'b' => 2]))->value(),
        );
    }

    #[Test]
    public function countsPairs(): void
    {
        $this->assertCount(3, new MapOf(['x' => 10, 'y' => 20, 'z' => 30]));
    }

    #[Test]
    public function iteratesPreservingOrderAndKeys(): void
    {
        $collected = [];
        foreach (new MapOf(['a' => 1, 'b' => 2, 'c' => 3]) as $key => $value) {
            $collected[$key] = $value;
        }
        $this->assertSame(['a' => 1, 'b' => 2, 'c' => 3], $collected);
    }

    #[Test]
    public function emptyMapHasZeroCount(): void
    {
        $this->assertCount(0, new MapOf([]));
    }

    #[Test]
    public function pairsFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new MapOf(['a' => 1, 'b' => 2]))->value(),
            MapOf::pairs(['a' => 1, 'b' => 2])->value(),
        );
    }

    #[Test]
    public function pairsFactoryAgreesWithPrimaryConstructorForEmpty(): void
    {
        self::assertSame(
            (new MapOf([]))->value(),
            MapOf::pairs([])->value(),
        );
    }
}
