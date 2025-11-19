<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\Mapped;
use Primus\Iterable\SequenceOf;
use Primus\Tests\Constraint\HasScalarValues;

/**
 * @since 0.2
 */
final class MappedTest extends TestCase
{
    #[Test]
    public function appliesFunctionToEachItem(): void
    {
        self::assertThat(
            new Mapped(fn (int $n): int => $n * 2, new SequenceOf([1, 2, 3])),
            new HasScalarValues([2, 4, 6]),
            'Mapped must apply the function to each item'
        );
    }

    #[Test]
    public function preservesListIndexing(): void
    {
        self::assertThat(
            new Mapped(fn (int $n): int => $n * 2, new SequenceOf([1 => 1, 2 => 2, 3 => 3])),
            new HasScalarValues([2, 4, 6]),
            'Mapped must preserve list indexing'
        );
    }
}
