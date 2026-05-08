<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\Map\PluckedBy;
use RuntimeException;

final class PluckedByTest extends TestCase
{
    #[Test]
    public function exposesEmptyResultForEmptySource(): void
    {
        $this->assertSame(
            [],
            (new PluckedBy(new ListOf(), 'id', 'name'))->value(),
        );
    }

    #[Test]
    public function indexesRowsByIndexColumnValueOfNameColumn(): void
    {
        $this->assertSame(
            [1 => 'Alice', 2 => 'Bob'],
            (new PluckedBy(
                new ListOf(
                    ['id' => 1, 'name' => 'Alice'],
                    ['id' => 2, 'name' => 'Bob'],
                ),
                'id',
                'name',
            ))->value(),
        );
    }

    #[Test]
    public function preservesRowOrderInResult(): void
    {
        $this->assertSame(
            ['z' => 'first', 'a' => 'second'],
            (new PluckedBy(
                new ListOf(
                    ['k' => 'z', 'v' => 'first'],
                    ['k' => 'a', 'v' => 'second'],
                ),
                'k',
                'v',
            ))->value(),
        );
    }

    #[Test]
    public function distinguishesNumericStringIndexFromIntegerIndex(): void
    {
        $this->assertSame(
            [1 => 'one', '01' => 'leadingZero'],
            (new PluckedBy(
                new ListOf(
                    ['k' => 1, 'v' => 'one'],
                    ['k' => '01', 'v' => 'leadingZero'],
                ),
                'k',
                'v',
            ))->value(),
        );
    }

    #[Test]
    public function preservesNullValueInValueColumn(): void
    {
        $this->assertSame(
            [1 => null, 2 => 'present'],
            (new PluckedBy(
                new ListOf(
                    ['id' => 1, 'name' => null],
                    ['id' => 2, 'name' => 'present'],
                ),
                'id',
                'name',
            ))->value(),
        );
    }

    #[Test]
    public function laterDuplicateIndexOverwritesEarlier(): void
    {
        $this->assertSame(
            [1 => 'second'],
            (new PluckedBy(
                new ListOf(
                    ['id' => 1, 'name' => 'first'],
                    ['id' => 1, 'name' => 'second'],
                ),
                'id',
                'name',
            ))->value(),
        );
    }

    #[Test]
    public function failsWhenAnyRowLacksIndexKey(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("PluckedBy index key 'id' missing in row at position 1");

        (new PluckedBy(
            new ListOf(
                ['id' => 1, 'name' => 'Alice'],
                ['name' => 'Bob'],
            ),
            'id',
            'name',
        ))->value();
    }

    #[Test]
    public function failsWhenAnyRowLacksValueKey(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("PluckedBy value key 'name' missing in row at position 0");

        (new PluckedBy(
            new ListOf(
                ['id' => 1],
            ),
            'id',
            'name',
        ))->value();
    }

    #[Test]
    public function failsWhenIndexValueIsNotArrayKey(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('PluckedBy index value at position 0 is array, expected int or string');

        (new PluckedBy(
            new ListOf(
                ['id' => ['nested'], 'name' => 'Alice'],
            ),
            'id',
            'name',
        ))->value();
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $plucked = new PluckedBy(
            new ListOf(
                ['id' => 1, 'name' => 'Alice'],
                ['id' => 2, 'name' => 'Bob'],
            ),
            'id',
            'name',
        );
        $this->assertSame(
            $plucked->value(),
            iterator_to_array($plucked),
        );
    }

    #[Test]
    public function countsAsManyAsRowsInSourceWithUniqueIndexes(): void
    {
        $this->assertCount(
            3,
            new PluckedBy(
                new ListOf(
                    ['id' => 1, 'v' => 'a'],
                    ['id' => 2, 'v' => 'b'],
                    ['id' => 3, 'v' => 'c'],
                ),
                'id',
                'v',
            ),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $rows = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
        ];
        $source = new ListOf(...$rows);
        $plucked = new PluckedBy($source, 'id', 'name');
        $plucked->value();
        iterator_to_array($plucked);
        $this->assertSame($rows, $source->value());
    }
}
