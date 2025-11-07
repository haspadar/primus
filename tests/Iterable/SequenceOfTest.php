<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\SequenceOf;
use Primus\Tests\Constraint\HasScalarValues;

/**
 * @since 0.2
 */
#[CoversClass(SequenceOf::class)]
final class SequenceOfTest extends TestCase
{
    #[Test]
    public function returnsArrayInValue(): void
    {
        self::assertThat(
            new SequenceOf(['a', 'b']),
            new HasScalarValues(['a', 'b'])
        );
    }

    #[Test]
    public function returnsArrayFromIterator(): void
    {
        self::assertThat(
            iterator_to_array((new SequenceOf(['x', 'y']))->getIterator()),
            new HasScalarValues(['x', 'y'])
        );
    }

    #[Test]
    public function returnsEmptyArrayFromEmptyIterator(): void
    {
        self::assertThat(
            iterator_to_array((new SequenceOf([]))->getIterator()),
            new HasScalarValues([])
        );
    }

    #[Test]
    public function returnsSameArrayFromValue(): void
    {
        self::assertThat(
            (new SequenceOf(['one', 'two']))->value(),
            new HasScalarValues(['one', 'two'])
        );
    }
}
