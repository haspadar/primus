<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\Diff;
use Primus\Map\MapOf;

final class DiffTest extends TestCase
{
    #[Test]
    public function returnsFirstSourceUntouchedWhenNoOtherSources(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2],
            (new Diff(new MapOf(['a' => 1, 'b' => 2])))->value(),
        );
    }

    #[Test]
    public function dropsKeysPresentInLaterSource(): void
    {
        $this->assertSame(
            ['a' => 1, 'c' => 3],
            (new Diff(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['b' => 99]),
            ))->value(),
        );
    }

    #[Test]
    public function dropsKeysPresentInAnyLaterSource(): void
    {
        $this->assertSame(
            ['a' => 1],
            (new Diff(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['b' => 99]),
                new MapOf(['c' => 0]),
            ))->value(),
        );
    }

    #[Test]
    public function preservesFirstSourceValuesUnchanged(): void
    {
        $this->assertSame(
            ['a' => 1, 'c' => 3],
            (new Diff(
                new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
                new MapOf(['b' => 'replacement-value-ignored']),
            ))->value(),
        );
    }

    #[Test]
    public function ignoresExcludedSourceValuesWhenSelectingPairs(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2],
            (new Diff(
                new MapOf(['a' => 1, 'b' => 2]),
                new MapOf(['c' => 1]),
            ))->value(),
        );
    }

    #[Test]
    public function preservesFirstSourceIterationOrder(): void
    {
        $this->assertSame(
            ['c' => 3, 'a' => 1],
            (new Diff(
                new MapOf(['c' => 3, 'b' => 2, 'a' => 1]),
                new MapOf(['b' => 0]),
            ))->value(),
        );
    }

    #[Test]
    public function distinguishesNumericStringKeyFromIntegerKey(): void
    {
        $this->assertSame(
            ['01' => 'leadingZero'],
            (new Diff(
                new MapOf([1 => 'one', '01' => 'leadingZero']),
                new MapOf([1 => 'remove-canonical-int-only']),
            ))->value(),
        );
    }

    #[Test]
    public function returnsEmptyWhenAllKeysExcluded(): void
    {
        $this->assertSame(
            [],
            (new Diff(
                new MapOf(['a' => 1, 'b' => 2]),
                new MapOf(['a' => 0, 'b' => 0]),
            ))->value(),
        );
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $diff = new Diff(
            new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
            new MapOf(['b' => 0]),
        );
        $this->assertSame(
            $diff->value(),
            iterator_to_array($diff),
        );
    }

    #[Test]
    public function countsPairsAfterExclusion(): void
    {
        $this->assertCount(
            1,
            new Diff(
                new MapOf(['a' => 1, 'b' => 2]),
                new MapOf(['a' => 0]),
            ),
        );
    }

    #[Test]
    public function leavesSourcesUntouchedAfterReading(): void
    {
        $first = new MapOf(['a' => 1, 'b' => 2]);
        $excluded = new MapOf(['b' => 99]);
        $diff = new Diff($first, $excluded);
        $diff->value();
        iterator_to_array($diff);
        $this->assertSame(['a' => 1, 'b' => 2], $first->value());
        $this->assertSame(['b' => 99], $excluded->value());
    }

    #[Test]
    public function ofMapsFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2, 'c' => 3]);
        $excluded = new MapOf(['b' => 99]);

        self::assertSame(
            (new Diff($source, $excluded))->value(),
            Diff::ofMaps($source, $excluded)->value(),
        );
    }

    #[Test]
    public function ofMapsFactoryAgreesWithPrimaryConstructorWithoutExcluded(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2]);

        self::assertSame(
            (new Diff($source))->value(),
            Diff::ofMaps($source)->value(),
        );
    }
}
