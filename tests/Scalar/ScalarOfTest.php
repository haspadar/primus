<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasCallCount;
use Primus\Tests\Constraint\HasScalarValue;
use Primus\Tests\CountCalls;

/**
 * @since 0.2
 */
final class ScalarOfTest extends TestCase
{
    #[Test]
    public function returnsEvaluatedValue(): void
    {
        self::assertThat(
            new ScalarOf(fn (): int => 42),
            new HasScalarValue(42),
            'ScalarOf must return the evaluated value'
        );
    }

    #[Test]
    public function invokesClosureWhenValueIsCalled(): void
    {
        $calls = new CountCalls();

        (new ScalarOf(fn (): int => $calls->record(1)))->value();

        self::assertThat(
            $calls,
            new HasCallCount(1),
            'ScalarOf must invoke the closure when value() is called'
        );
    }
}
