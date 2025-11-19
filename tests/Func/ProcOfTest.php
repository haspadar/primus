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
use Primus\Tests\Constraint\HasCallCount;
use Primus\Tests\CountCalls;

/**
 * @since 0.3
 */
final class ProcOfTest extends TestCase
{
    #[Test]
    public function executesClosureWithInput(): void
    {
        $calls = new CountCalls();

        (new ProcOf(fn (int $x): int => $calls->record($x)))->exec(5);

        self::assertThat($calls, new HasCallCount(1));
    }
}
