<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\EqualTo;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarBoolValue;

/**
 * @since 0.2
 */
final class EqualToTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenValuesAreEqual(): void
    {
        self::assertThat(
            new EqualTo(
                new ScalarOf(fn (): int => 42),
                new ScalarOf(fn (): int => 42)
            ),
            new HasScalarBoolValue(true),
            'EqualTo must return true when values are equal'
        );
    }

    #[Test]
    public function returnsFalseWhenValuesAreDifferent(): void
    {
        self::assertThat(
            new EqualTo(
                new ScalarOf(fn (): string => 'foo'),
                new ScalarOf(fn (): string => 'bar')
            ),
            new HasScalarBoolValue(false),
            'EqualTo must return false when values are different'
        );
    }

    #[Test]
    public function returnsTrueWhenBothEmptyStrings(): void
    {
        self::assertThat(
            new EqualTo(
                new ScalarOf(fn (): string => ''),
                new ScalarOf(fn (): string => '')
            ),
            new HasScalarBoolValue(true),
            'EqualTo must return true when both values are empty strings'
        );
    }
}
