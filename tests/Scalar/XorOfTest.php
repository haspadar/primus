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
use Primus\Tests\Constraint\HasBoolValue;
use Primus\Tests\Constraint\Throws;

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
            new HasBoolValue(true),
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
            new HasBoolValue(false),
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
            new HasBoolValue(false),
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
            new HasBoolValue(false),
        );
    }

    #[Test]
    public function throwsWhenNoConditionsProvided(): void
    {
        self::assertThat(
            new ScalarOf(fn () => (new XorOf())->value()),
            new Throws(InvalidArgumentException::class),
        );
    }
}
