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
use Primus\Tests\Constraint\HasBoolValue;

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
            new HasBoolValue(true)
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
            new HasBoolValue(false)
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
            new HasBoolValue(true)
        );
    }
}
