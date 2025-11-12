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
use Primus\Scalar\Ternary;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.3
 */
final class TernaryTest extends TestCase
{
    #[Test]
    public function returnsYesWhenConditionTrue(): void
    {
        self::assertThat(
            new Ternary(
                new ScalarOf(new FuncOf(fn (): bool => true)),
                new Constant('yes'),
                new Constant('no')
            ),
            new HasScalarValue('yes')
        );
    }

    #[Test]
    public function returnsNoWhenConditionFalse(): void
    {
        self::assertThat(
            new Ternary(
                new ScalarOf(new FuncOf(fn (): bool => false)),
                new Constant('yes'),
                new Constant('no')
            ),
            new HasScalarValue('no')
        );
    }
}
