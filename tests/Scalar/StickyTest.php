<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Scalar\ScalarOf;
use Primus\Scalar\Sticky;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.3
 */
final class StickyTest extends TestCase
{
    #[Test]
    public function cachesValue(): void
    {
        $scalar = new Sticky(
            new ScalarOf(new FuncOf(fn (): string => uniqid('', true)))
        );

        self::assertSame(
            $scalar->value(),
            $scalar->value(),
            'Sticky should return the same cached value'
        );
    }

    #[Test]
    public function returnsStoredValue(): void
    {
        self::assertThat(
            new Sticky(
                new ScalarOf(new FuncOf(fn (): int => 42))
            ),
            new HasScalarValue(42),
        );
    }
}
