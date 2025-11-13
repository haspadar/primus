<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\TextOfScalar;

/**
 * @since 0.2
 */
final class TextOfScalarTest extends TestCase
{
    #[Test]
    public function returnsValueFromScalar(): void
    {
        self::assertThat(
            new TextOfScalar(
                new ScalarOf(
                    new FuncOf(fn (): string => 'hello')
                )
            ),
            new HasTextValue('hello')
        );
    }
}
