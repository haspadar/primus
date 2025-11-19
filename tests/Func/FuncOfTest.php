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

/**
 * @since 0.3
 */
final class FuncOfTest extends TestCase
{
    #[Test]
    public function appliesClosureToInput(): void
    {
        $func = new FuncOf(fn (int $x): int => $x * 2);
        self::assertSame(6, $func->apply(3), 'Doubles input value');
    }
}
