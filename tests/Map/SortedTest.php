<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\MapOf;
use Primus\Map\Sorted;

final class SortedTest extends TestCase
{
    #[Test]
    public function exposesEmptyMapAsEmpty(): void
    {
        $this->assertSame([], (new Sorted(new MapOf([])))->value());
    }

    #[Test]
    public function ordersIntegersAscendingAndPreservesKeys(): void
    {
        $this->assertSame(
            ['a' => 1, 'c' => 2, 'b' => 3],
            (new Sorted(new MapOf(['b' => 3, 'a' => 1, 'c' => 2])))->value(),
        );
    }

    #[Test]
    public function ordersStringsLexicographicallyAndPreservesKeys(): void
    {
        $this->assertSame(
            ['x' => 'alpha', 'z' => 'bravo', 'y' => 'charlie'],
            (new Sorted(new MapOf(['y' => 'charlie', 'x' => 'alpha', 'z' => 'bravo'])))->value(),
        );
    }

    #[Test]
    public function preservesRelativeOrderOfEqualValues(): void
    {
        $this->assertSame(
            ['b' => 1, 'd' => 1, 'a' => 2, 'c' => 2, 'e' => 3],
            (new Sorted(new MapOf(['a' => 2, 'b' => 1, 'c' => 2, 'd' => 1, 'e' => 3])))->value(),
        );
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $sorted = new Sorted(new MapOf(['b' => 3, 'a' => 1, 'c' => 2]));
        $this->assertSame(
            $sorted->value(),
            iterator_to_array($sorted),
        );
    }

    #[Test]
    public function countsSourcePairs(): void
    {
        $this->assertCount(
            3,
            new Sorted(new MapOf(['b' => 3, 'a' => 1, 'c' => 2])),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new MapOf(['b' => 3, 'a' => 1, 'c' => 2]);
        $sorted = new Sorted($source);
        $sorted->value();
        iterator_to_array($sorted);
        $this->assertSame(['b' => 3, 'a' => 1, 'c' => 2], $source->value());
    }

    #[Test]
    public function ofMapFactoryAgreesWithPrimaryConstructor(): void
    {
        $map = new MapOf(['b' => 3, 'a' => 1, 'c' => 2]);

        self::assertSame(
            (new Sorted($map))->value(),
            Sorted::ofMap($map)->value(),
        );
    }
}
