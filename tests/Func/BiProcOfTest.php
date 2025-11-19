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

/**
 * @since 0.3
 */
final class BiProcOfTest extends TestCase
{
    #[Test]
    public function executesClosureWithTwoInputs(): void
    {
        $sum = 0;

        (new BiProcOf(function (int $a, int $b) use (&$sum): void {
            $sum = $a + $b;
        }))->exec(2, 3);

        self::assertSame(5, $sum, 'BiProcOf must modify the state as expected');
    }
}
