<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\Chunks;
use Primus\List\ListOf;
use Primus\List\List_;
use ValueError;

final class ChunksTest extends TestCase
{
    #[Test]
    public function splitsListIntoChunksOfGivenSize(): void
    {
        $chunks = (new Chunks(new ListOf(1, 2, 3, 4, 5, 6), 2))->value();

        $this->assertSame(
            [[1, 2], [3, 4], [5, 6]],
            array_map(static fn(List_ $chunk): array => $chunk->value(), $chunks),
        );
    }

    #[Test]
    public function lastChunkHoldsRemainderWhenSizeDoesNotDivideLength(): void
    {
        $chunks = (new Chunks(new ListOf(1, 2, 3, 4, 5), 2))->value();

        $this->assertSame(
            [2, 2, 1],
            array_map(static fn(List_ $chunk): int => count($chunk), $chunks),
        );
    }

    #[Test]
    public function preservesElementOrderAcrossChunks(): void
    {
        $chunks = (new Chunks(new ListOf('a', 'b', 'c', 'd'), 3))->value();

        $this->assertSame(
            ['a', 'b', 'c', 'd'],
            array_merge(...array_map(static fn(List_ $chunk): array => $chunk->value(), $chunks)),
        );
    }

    #[Test]
    public function emptyOriginProducesEmptyResult(): void
    {
        $this->assertSame(
            [],
            (new Chunks(new ListOf(), 3))->value(),
        );
    }

    #[Test]
    public function eachChunkHasSequentialKeysStartingAtZero(): void
    {
        $chunks = (new Chunks(new ListOf(1, 2, 3, 4), 2))->value();

        foreach ($chunks as $chunk) {
            $this->assertSame([0, 1], array_keys($chunk->value()));
        }
    }

    #[Test]
    public function resultHasSequentialKeysStartingAtZero(): void
    {
        $this->assertSame(
            [0, 1, 2],
            array_keys((new Chunks(new ListOf(1, 2, 3, 4, 5), 2))->value()),
        );
    }

    #[Test]
    public function zeroSizeRejectsValueAccess(): void
    {
        $this->expectException(ValueError::class);

        (new Chunks(new ListOf(1, 2, 3), 0))->value();
    }

    #[Test]
    public function negativeSizeRejectsValueAccess(): void
    {
        $this->expectException(ValueError::class);

        (new Chunks(new ListOf(1, 2, 3), -1))->value();
    }

    #[Test]
    public function iteratesYieldingTheChunks(): void
    {
        $collected = [];
        foreach (new Chunks(new ListOf(1, 2, 3, 4), 2) as $chunk) {
            $collected[] = $chunk->value();
        }
        $this->assertSame([[1, 2], [3, 4]], $collected);
    }

    #[Test]
    public function reportsCountOfChunks(): void
    {
        $this->assertCount(3, new Chunks(new ListOf(1, 2, 3, 4, 5), 2));
    }

    #[Test]
    public function ofListFactoryAgreesWithPrimaryConstructor(): void
    {
        $list = new ListOf(1, 2, 3, 4, 5);

        self::assertEquals(
            (new Chunks($list, 2))->value(),
            Chunks::ofList($list, 2)->value(),
        );
    }
}
