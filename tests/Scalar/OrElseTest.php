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
use Primus\Scalar\OrElse;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarValue;
use RuntimeException;

/**
 * @since 0.3
 */
final class OrElseTest extends TestCase
{
    #[Test]
    public function returnsAlternativeWhenPrimaryFails(): void
    {
        self::assertThat(
            new OrElse(
                new ScalarOf(new FuncOf(fn (): string => throw new RuntimeException('boom'))),
                new ScalarOf(new FuncOf(fn (): string => 'fallback'))
            ),
            new HasScalarValue('fallback')
        );
    }

    #[Test]
    public function returnsPrimaryValueWhenNoException(): void
    {
        self::assertThat(
            new OrElse(
                new ScalarOf(new FuncOf(fn (): string => 'main')),
                new ScalarOf(new FuncOf(fn (): string => 'alt'))
            ),
            new HasScalarValue('main')
        );
    }
}
