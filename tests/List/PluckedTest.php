<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\List\Plucked;
use RuntimeException;

final class PluckedTest extends TestCase
{
    #[Test]
    public function exposesEmptyResultForEmptySource(): void
    {
        $this->assertSame(
            [],
            (new Plucked(new ListOf(), 'name'))->value(),
        );
    }

    #[Test]
    public function picksColumnFromEveryRowInSourceOrder(): void
    {
        $this->assertSame(
            ['Alice', 'Bob', 'Carol'],
            (new Plucked(
                new ListOf(
                    ['id' => 1, 'name' => 'Alice'],
                    ['id' => 2, 'name' => 'Bob'],
                    ['id' => 3, 'name' => 'Carol'],
                ),
                'name',
            ))->value(),
        );
    }

    #[Test]
    public function preservesNullValuesInColumn(): void
    {
        $this->assertSame(
            [1, null, 3],
            (new Plucked(
                new ListOf(
                    ['v' => 1],
                    ['v' => null],
                    ['v' => 3],
                ),
                'v',
            ))->value(),
        );
    }

    #[Test]
    public function supportsIntegerKey(): void
    {
        $this->assertSame(
            ['first', 'second'],
            (new Plucked(
                new ListOf(
                    [0 => 'first', 1 => 'extra'],
                    [0 => 'second', 1 => 'extra'],
                ),
                0,
            ))->value(),
        );
    }

    #[Test]
    public function distinguishesNumericStringKeyFromIntegerKey(): void
    {
        $this->assertSame(
            ['leadingZero'],
            (new Plucked(
                new ListOf(
                    [1 => 'one', '01' => 'leadingZero'],
                ),
                '01',
            ))->value(),
        );
    }

    #[Test]
    public function failsWhenAnyRowLacksKey(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Plucked key 'name' missing in row at position 1");

        (new Plucked(
            new ListOf(
                ['id' => 1, 'name' => 'Alice'],
                ['id' => 2],
            ),
            'name',
        ))->value();
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $plucked = new Plucked(
            new ListOf(
                ['v' => 'a'],
                ['v' => 'b'],
            ),
            'v',
        );
        $this->assertSame(
            $plucked->value(),
            iterator_to_array($plucked),
        );
    }

    #[Test]
    public function countsAsManyAsRowsInSource(): void
    {
        $this->assertCount(
            3,
            new Plucked(
                new ListOf(
                    ['v' => 1],
                    ['v' => 2],
                    ['v' => 3],
                ),
                'v',
            ),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $rows = [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
        ];
        $source = new ListOf(...$rows);
        $plucked = new Plucked($source, 'name');
        $plucked->value();
        iterator_to_array($plucked);
        $this->assertSame($rows, $source->value());
    }

    #[Test]
    public function ofListFactoryAgreesWithPrimaryConstructor(): void
    {
        $list = new ListOf(
            ['name' => 'a'],
            ['name' => 'b'],
        );

        self::assertSame(
            (new Plucked($list, 'name'))->value(),
            Plucked::ofList($list, 'name')->value(),
        );
    }
}
