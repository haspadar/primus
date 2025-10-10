<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use Primus\Iterable\SequenceOf;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SequenceOfTest extends TestCase
{
    #[Test]
    public function returnsArrayInValue(): void
    {
        $this->assertSame(
            ['a', 'b'],
            new SequenceOf(['a', 'b'])->value(),
            'Expected value() to return original array'
        );
    }

    #[Test]
    public function returnsArrayFromIterator(): void
    {
        $this->assertSame(
            ['x', 'y'],
            iterator_to_array(new SequenceOf(['x', 'y'])->getIterator()),
            'Expected getIterator() to yield original array'
        );
    }

    #[Test]
    public function returnsEmptyArrayFromEmptyIterator(): void
    {
        $this->assertSame(
            [],
            iterator_to_array(new SequenceOf([])->getIterator()),
            'Expected getIterator() to yield empty array'
        );
    }
}
