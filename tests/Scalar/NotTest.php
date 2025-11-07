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
use Primus\Tests\Constraint\HasBoolValue;

/**
 * @since 0.2
 */
final class NotTest extends TestCase
{
    #[Test]
    public function returnsFalseWhenConditionTrue(): void
    {
        self::assertThat(
            new Not(new ScalarOf(fn () => true)),
            new HasBoolValue(false)
        );
    }

    #[Test]
    public function returnsTrueWhenConditionFalse(): void
    {
        self::assertThat(
            new Not(new ScalarOf(fn () => false)),
            new HasBoolValue(true)
        );
    }
}
