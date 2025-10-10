<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use Primus\Iterable\Mapped;
use Primus\Iterable\SequenceOf;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MappedTest extends TestCase
{
    #[Test]
    public function appliesFunctionToEachItem(): void
    {
        $this->assertSame(
            [2, 4, 6],
            iterator_to_array(
                new Mapped(fn (int $n) => $n * 2, new SequenceOf([1, 2, 3]))
            ),
            'Expected each number to be doubled'
        );
    }

    #[Test]
    public function preservesListIndexing(): void
    {
        $result = iterator_to_array(
            new Mapped(fn (int $n) => $n * 2, new SequenceOf([1 => 1, 2 => 2, 3 => 3]))
        );

        $this->assertSame([2, 4, 6], $result, 'Keys should be reset to sequential integers');
    }
}
