<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Scalar\Constant;
use Primus\Scalar\ScalarOf;
use Primus\Scalar\ScalarWithFallback;
use Primus\Tests\Constraint\HasScalarValue;
use RuntimeException;

/**
 * @since 0.3
 */
final class ScalarWithFallbackTest extends TestCase
{
    #[Test]
    public function returnsFallbackWhenExceptionThrown(): void
    {
        self::assertThat(
            new ScalarWithFallback(
                new ScalarOf(new FuncOf(fn (): mixed => throw new RuntimeException('fail'))),
                new Constant('safe')
            ),
            new HasScalarValue('safe')
        );
    }

    #[Test]
    public function returnsOriginValueWhenNoException(): void
    {
        self::assertThat(
            new ScalarWithFallback(
                new ScalarOf(new FuncOf(fn (): string => 'ok')),
                new Constant('backup')
            ),
            new HasScalarValue('ok')
        );
    }
}
