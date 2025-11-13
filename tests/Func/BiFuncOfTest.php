<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiFuncOf;

/**
 * @since 0.3
 */
final class BiFuncOfTest extends TestCase
{
    #[Test]
    public function appliesClosureToTwoInputs(): void
    {
        $func = new BiFuncOf(fn (int $a, int $b): int => $a + $b);
        self::assertSame(7, $func->apply(3, 4), 'Adds two numbers');
    }
}
