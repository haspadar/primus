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
use Primus\Scalar\OrOf;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarBoolValue;
use Primus\Tests\Constraint\ThrowsValue;

/**
 * @since 0.2
 */
final class OrOfTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenAtLeastOneTrue(): void
    {
        self::assertThat(
            new OrOf(
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): true => true)
            ),
            new HasScalarBoolValue(true),
            'OrOf must return true when at least one scalar is true'
        );
    }

    #[Test]
    public function returnsFalseWhenAllFalse(): void
    {
        self::assertThat(
            new OrOf(
                new ScalarOf(fn (): false => false),
                new ScalarOf(fn (): false => false)
            ),
            new HasScalarBoolValue(false),
            'OrOf must return false when all scalars are false'
        );
    }

    #[Test]
    public function returnsTrueWhenAllTrue(): void
    {
        self::assertThat(
            new OrOf(
                new ScalarOf(fn (): true => true),
                new ScalarOf(fn (): true => true)
            ),
            new HasScalarBoolValue(true),
            'OrOf must return true when all scalars are true'
        );
    }

    #[Test]
    public function throwsWhenNoScalarsProvided(): void
    {
        self::assertThat(
            new ScalarOf(fn () => (new OrOf())->value()),
            new ThrowsValue(InvalidArgumentException::class),
            'OrOf must throw an exception when no scalars are provided'
        );
    }
}
