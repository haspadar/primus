<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\ScalarOf;
use Primus\Scalar\XorOf;
use Primus\Tests\Constraint\HasScalarBoolValue;
use Primus\Tests\Constraint\ThrowsValue;

/**
 * @since 0.2
 */
final class XorOfTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenExactlyOneConditionTrue(): void
    {
        self::assertThat(
            new XorOf(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): false => false),
            ),
            new HasScalarBoolValue(true),
            'XorOf must return true when exactly one condition is true'
        );
    }

    #[Test]
    public function returnsFalseWhenBothTrue(): void
    {
        self::assertThat(
            new XorOf(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): true => true),
            ),
            new HasScalarBoolValue(false),
            'XorOf must return false when both conditions are true'
        );
    }

    #[Test]
    public function returnsFalseWhenBothFalse(): void
    {
        self::assertThat(
            new XorOf(
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): false => false),
            ),
            new HasScalarBoolValue(false),
            'XorOf must return false when both conditions are false'
        );
    }

    #[Test]
    public function returnsFalseWhenEvenNumberTrue(): void
    {
        self::assertThat(
            new XorOf(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): true => true),
            ),
            new HasScalarBoolValue(false),
            'XorOf must return false when an even number of conditions are true'
        );
    }

    #[Test]
    public function throwsWhenNoConditionsProvided(): void
    {
        self::assertThat(
            new ScalarOf(fn () => (new XorOf())->value()),
            new ThrowsValue(InvalidArgumentException::class),
            'XorOf must throw an exception when no conditions are provided'
        );
    }
}
