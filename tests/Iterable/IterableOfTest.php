<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\IterableOf;
use Primus\Tests\Constraint\HasIteratorValues;

/**
 * @since 0.5
 */
final class IterableOfTest extends TestCase
{
    #[Test]
    public function yieldsAllValuesInOrder(): void
    {
        self::assertThat(
            new IterableOf([10, 20, 30]),
            new HasIteratorValues([10, 20, 30]),
        );
    }

    #[Test]
    public function yieldsEmptySequence(): void
    {
        self::assertThat(
            new IterableOf([]),
            new HasIteratorValues([]),
        );
    }

    #[Test]
    public function eachIterationStartsFromBeginning(): void
    {
        $iterable = new IterableOf([1, 2]);

        iterator_to_array($iterable);

        self::assertThat(
            $iterable,
            new HasIteratorValues([1, 2]),
        );
    }

    #[Test]
    public function ignoresOriginalArrayKeys(): void
    {
        self::assertThat(
            new IterableOf([2 => 5, 10 => 6, 50 => 7]),
            new HasIteratorValues([5, 6, 7]),
        );
    }

    #[Test]
    public function handlesSparseArrayCorrectly(): void
    {
        $arr = [];
        $arr[10] = 'a';
        $arr[20] = 'b';

        self::assertThat(
            new IterableOf($arr),
            new HasIteratorValues(['a', 'b']),
        );
    }
}
