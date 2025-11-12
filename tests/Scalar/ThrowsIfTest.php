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
use Primus\Scalar\Constant;
use Primus\Scalar\ScalarOf;
use Primus\Scalar\ThrowsIf;
use Primus\Tests\Constraint\HasScalarValue;
use RuntimeException;

/**
 * @since 0.3
 */
final class ThrowsIfTest extends TestCase
{
    #[Test]
    public function throwsExceptionWhenConditionTrue(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Condition failed');

        (new ThrowsIf(
            new ScalarOf(new FuncOf(fn (): bool => true)),
            new Constant('ok'),
            new RuntimeException('Condition failed')
        ))->value();
    }

    #[Test]
    public function returnsValueWhenConditionFalse(): void
    {
        self::assertThat(
            new ThrowsIf(
                new ScalarOf(new FuncOf(fn (): bool => false)),
                new Constant('ok'),
                new RuntimeException('never')
            ),
            new HasScalarValue('ok')
        );
    }
}
