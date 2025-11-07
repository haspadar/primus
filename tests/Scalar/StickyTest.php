<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\ScalarOf;
use Primus\Scalar\Sticky;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.2
 */
#[CoversClass(Sticky::class)]
final class StickyTest extends TestCase
{
    #[Test]
    public function cachesValue(): void
    {
        $scalar = new Sticky(new ScalarOf(fn () => uniqid('', true)));

        $firstCall = $scalar->value();
        $secondCall = $scalar->value();

        self::assertThat(
            new ScalarOf(fn () => $firstCall === $secondCall),
            new HasScalarValue(true)
        );
    }

    #[Test]
    public function returnsStoredValue(): void
    {
        self::assertThat(
            new Sticky(new ScalarOf(fn () => 42)),
            new HasScalarValue(42)
        );
    }
}
