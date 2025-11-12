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
use Primus\Scalar\Mapped;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.3
 */
final class MappedTest extends TestCase
{
    #[Test]
    public function appliesFunctionToOriginScalar(): void
    {
        self::assertThat(
            new Mapped(
                new FuncOf(fn (int $x): int => $x * 2),
                new ScalarOf(new FuncOf(fn (): int => 21))
            ),
            new HasScalarValue(42)
        );
    }
}
