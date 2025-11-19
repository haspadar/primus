<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\Not;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarBoolValue;

/**
 * @since 0.2
 */
final class NotTest extends TestCase
{
    #[Test]
    public function returnsFalseWhenConditionTrue(): void
    {
        self::assertThat(
            new Not(new ScalarOf(fn (): true => true)),
            new HasScalarBoolValue(false),
            'Not must return false when the condition is true'
        );
    }

    #[Test]
    public function returnsTrueWhenConditionFalse(): void
    {
        self::assertThat(
            new Not(new ScalarOf(fn (): false => false)),
            new HasScalarBoolValue(true),
            'Not must return true when the condition is false'
        );
    }
}
