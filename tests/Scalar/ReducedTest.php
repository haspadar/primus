<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiFuncOf;
use Primus\Scalar\Reduced;
use Primus\Sequence\SequenceOf;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.3
 */
final class ReducedTest extends TestCase
{
    #[Test]
    public function reducesSequenceOfIntegers(): void
    {
        self::assertThat(
            new Reduced(
                new BiFuncOf(fn (int $a, int $b): int => $a + $b),
                0,
                new SequenceOf([1, 2, 3])
            ),
            new HasScalarValue(6),
        );
    }

    #[Test]
    public function reducesSequenceOfStrings(): void
    {
        self::assertThat(
            new Reduced(
                new BiFuncOf(fn (string $a, string $b): string => $a . $b),
                '',
                new SequenceOf(['a', 'b', 'c'])
            ),
            new HasScalarValue('abc'),
        );
    }

    #[Test]
    public function returnsIdentityWhenSequenceEmpty(): void
    {
        self::assertThat(
            new Reduced(
                new BiFuncOf(fn (int $a, int $b): int => $a + $b),
                100,
                new SequenceOf([])
            ),
            new HasScalarValue(100),
        );
    }
}
