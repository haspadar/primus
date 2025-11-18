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
use Primus\Scalar\AndOf;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarBoolValue;
use Primus\Tests\Constraint\Throws;

/**
 * @since 0.2
 */
final class AndOfTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenAllTrue(): void
    {
        self::assertThat(
            new AndOf(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): true => true)
            ),
            new HasScalarBoolValue(true),
            'AndOf must return true when all scalars are true'
        );
    }

    #[Test]
    public function returnsFalseWhenOneIsFalse(): void
    {
        self::assertThat(
            new AndOf(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): false => false)
            ),
            new HasScalarBoolValue(false),
            'AndOf must return false when at least one scalar is false'
        );
    }

    #[Test]
    public function returnsFalseWhenAllFalse(): void
    {
        self::assertThat(
            new AndOf(
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): false => false)
            ),
            new HasScalarBoolValue(false),
            'AndOf must return false when all scalars are false'
        );
    }

    #[Test]
    public function throwsWhenNoScalarsProvided(): void
    {
        self::assertThat(
            new ScalarOf(fn () => (new AndOf())->value()),
            new Throws(InvalidArgumentException::class),
            'AndOf must throw an exception when no scalars are provided'
        );
    }
}
