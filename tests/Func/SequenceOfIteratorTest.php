<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Sequence;

use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Sequence\SequenceOfIterator;
use Primus\Tests\LazyIterable;

final class SequenceOfIteratorTest extends TestCase
{
    #[Test]
    public function doesNotStartBeforeIteration(): void
    {
        $iterable = new LazyIterable([1, 2, 3]);
        new SequenceOfIterator($iterable);

        $this->assertFalse($iterable->started());
    }

    #[Test]
    public function startsWhenIterated(): void
    {
        $iterable = new LazyIterable([1, 2, 3]);
        $seq = new SequenceOfIterator($iterable);

        iterator_to_array($seq);

        $this->assertTrue($iterable->started());
    }

    #[Test]
    public function convertsToArrayViaValue(): void
    {
        $seq = new SequenceOfIterator((function (): Generator {
            yield 'x';
            yield 'y';
        })());

        $this->assertSame(['x', 'y'], $seq->value());
    }
}
