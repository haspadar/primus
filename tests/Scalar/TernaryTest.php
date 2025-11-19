<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\Constant;
use Primus\Scalar\ScalarOf;
use Primus\Scalar\Ternary;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.2
 */
final class TernaryTest extends TestCase
{
    #[Test]
    public function returnsYesWhenConditionTrue(): void
    {
        self::assertThat(
            new Ternary(
                new ScalarOf(fn (): true => true),
                new Constant('yes'),
                new Constant('no')
            ),
            new HasScalarValue('yes'),
            'Ternary must return the "yes" value when the condition is true'
        );
    }

    #[Test]
    public function returnsNoWhenConditionFalse(): void
    {
        self::assertThat(
            new Ternary(
                new ScalarOf(fn (): false => false),
                new Constant('yes'),
                new Constant('no')
            ),
            new HasScalarValue('no'),
            'Ternary must return the "no" value when the condition is false'
        );
    }
}
