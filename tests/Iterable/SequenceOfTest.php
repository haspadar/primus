<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\SequenceOf;
use Primus\Tests\Constraint\HasScalarValues;

/**
 * @since 0.2
 */
final class SequenceOfTest extends TestCase
{
    #[Test]
    public function returnsValuesWhenIterated(): void
    {
        self::assertThat(
            iterator_to_array((new SequenceOf(['x', 'y']))->getIterator()),
            new HasScalarValues(['x', 'y'])
        );
    }

    #[Test]
    public function returnsEmptyWhenIteratedOverEmptySequence(): void
    {
        self::assertThat(
            iterator_to_array((new SequenceOf([]))->getIterator()),
            new HasScalarValues([])
        );
    }

    #[Test]
    public function returnsArrayWhenValueCalled(): void
    {
        self::assertThat(
            (new SequenceOf(['one', 'two']))->value(),
            new HasScalarValues(['one', 'two'])
        );
    }
}
