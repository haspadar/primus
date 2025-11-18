<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiProcOf;
use Primus\Tests\Constraint\ExecBiProcTo;

/**
 * @since 0.3
 */
final class BiProcOfTest extends TestCase
{
    #[Test]
    public function executesClosureWithTwoInputs(): void
    {
        $sum = 0;

        self::assertThat(
            new BiProcOf(function (int $a, int $b) use (&$sum): void {
                $sum = $a + $b;
            }),
            new ExecBiProcTo([2, 3]),
            'BiProcOf must execute the closure with two inputs'
        );

        self::assertSame(5, $sum, 'BiProcOf must modify the state as expected');
    }
}
