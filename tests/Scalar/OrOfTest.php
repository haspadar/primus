<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Exception;
use Primus\Scalar\OrOf;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasBoolValue;
use Primus\Tests\Constraint\Throws;

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
            new HasBoolValue(true)
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
            new HasBoolValue(false)
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
            new HasBoolValue(true)
        );
    }

    #[Test]
    public function throwsWhenNoScalarsProvided(): void
    {
        self::assertThat(
            new ScalarOf(fn () => (new OrOf())->value()),
            new Throws(Exception::class)
        );
    }
}
