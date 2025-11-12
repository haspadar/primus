<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Func\Retry;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasScalarValue;

/**
 * @since 0.3
 */
final class RetryTest extends TestCase
{
    #[Test]
    public function succeedsAfterRetries(): void
    {
        $attempts = 0;
        $func = new FuncOf(function (int $x) use (&$attempts): int {
            $attempts++;
            if ($attempts < 3) {
                throw new \RuntimeException('fail');
            }
            return $x * 2;
        });

        self::assertThat(
            new ScalarOf(new FuncOf(fn (): mixed => (new Retry($func, 3, 0))->apply(5))),
            new HasScalarValue(10)
        );
    }

    #[Test]
    public function failsAfterMaxRetries(): void
    {
        $func = new FuncOf(fn (int $x): int => throw new \RuntimeException('always fail'));

        $this->expectException(\RuntimeException::class);
        (new Retry($func, 3, 0))->apply(5);
    }

}
