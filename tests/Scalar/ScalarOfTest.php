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

final class ScalarOfTest extends TestCase
{
    #[Test]
    public function returnsValueWhenClosureIsEvaluated(): void
    {
        self::assertSame(
            42,
            new ScalarOf(fn () => 42)->value(),
            'ScalarOf should return the result of the closure.'
        );
    }

    #[Test]
    public function callsClosureWhenValueCalled(): void
    {
        $called = false;

        new ScalarOf(function () use (&$called): int {
            $called = true;
            return 1;
        })->value();

        self::assertTrue($called, 'ScalarOf should call the closure when value() is invoked.');
    }

}
