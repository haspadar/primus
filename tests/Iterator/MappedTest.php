<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterator;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Iterator\IteratorOf;
use Primus\Iterator\Mapped;
use Primus\Tests\Constraint\EqualsValue;
use Primus\Tests\Constraint\HasIteratorValues;
use Primus\Tests\Constraint\ThrowsClosure;

/**
 * @since 0.5
 */
final class MappedTest extends TestCase
{
    #[Test]
    public function mapsValuesUsingProvidedFunction(): void
    {
        self::assertThat(
            new Mapped(
                new IteratorOf([1, 2, 3]),
                new FuncOf(fn (int $value): int => $value * 10),
            ),
            new HasIteratorValues([10, 20, 30]),
        );
    }

    #[Test]
    public function mapsValuesToDifferentType(): void
    {
        self::assertThat(
            new Mapped(
                new IteratorOf([1, 2]),
                new FuncOf(fn (int $value): string => 'v' . $value),
            ),
            new HasIteratorValues(['v1', 'v2']),
        );
    }

    #[Test]
    public function producesEmptyResultWhenOriginIsEmpty(): void
    {
        self::assertThat(
            new Mapped(
                new IteratorOf([]),
                new FuncOf(fn (mixed $value): mixed => $value),
            ),
            new HasIteratorValues([]),
        );
    }

    #[Test]
    public function incrementsKeySequentially(): void
    {
        $it = new Mapped(
            new IteratorOf([10, 20, 30]),
            new FuncOf(fn (int $value): int => $value),
        );

        $it->rewind();
        $it->next();
        $it->next();

        self::assertThat(
            $it->key(),
            new EqualsValue(2),
        );
    }

    #[Test]
    public function rewindingResetsPosition(): void
    {
        $mapped = new Mapped(
            new IteratorOf([10, 20]),
            new FuncOf(fn (int $value): int => $value * 10),
        );

        iterator_to_array($mapped);
        $mapped->rewind();

        self::assertThat(
            $mapped,
            new HasIteratorValues([100, 200]),
        );
    }

    #[Test]
    public function throwsWhenMappingFunctionFails(): void
    {
        $mapped = new Mapped(
            new IteratorOf([1]),
            new FuncOf(fn (int $_): int => throw new \RuntimeException('fail')),
        );

        $mapped->rewind();

        self::assertThat(
            fn (): mixed => $mapped->current(),
            new ThrowsClosure(\RuntimeException::class),
        );
    }
}
