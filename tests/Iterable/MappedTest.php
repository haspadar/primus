<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Iterable\IterableOf;
use Primus\Iterable\Mapped;
use Primus\Tests\Constraint\EqualsValue;
use Primus\Tests\Constraint\HasIteratorValues;

final class MappedTest extends TestCase
{
    #[Test]
    public function mapsValues(): void
    {
        self::assertThat(
            new Mapped(
                new IterableOf([1, 2, 3]),
                new FuncOf(fn (int $x): int => $x * 10),
            ),
            new HasIteratorValues([10, 20, 30]),
        );
    }

    #[Test]
    public function mapsEmptyIterable(): void
    {
        self::assertThat(
            new Mapped(
                new IterableOf([]),
                new FuncOf(fn ($x) => $x),
            ),
            new HasIteratorValues([]),
        );
    }

    #[Test]
    public function mapsArrayInputs(): void
    {
        self::assertThat(
            new Mapped(
                new IterableOf(['a', 'b', 'c']),
                new FuncOf(fn (string $s): string => strtoupper($s)),
            ),
            new HasIteratorValues(['A', 'B', 'C']),
        );
    }

    #[Test]
    public function producesFreshIteratorEachTime(): void
    {
        $mapped = new Mapped(
            new IterableOf([1, 2]),
            new FuncOf(fn (int $x): int => $x + 10),
        );

        iterator_to_array($mapped->getIterator());

        self::assertThat(
            iterator_to_array($mapped->getIterator()),
            new EqualsValue([11, 12]),
        );
    }
}
