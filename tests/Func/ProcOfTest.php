<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\ProcOf;

/**
 * @since 0.3
 */
final class ProcOfTest extends TestCase
{
    #[Test]
    public function executesClosureWithInput(): void
    {
        $called = false;
        (new ProcOf(function (int $x) use (&$called): void {
            if ($x === 5) {
                $called = true;
            }
        }))->exec(5);

        self::assertTrue($called, 'Procedure must be executed');
    }
}
