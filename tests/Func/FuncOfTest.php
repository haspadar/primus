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
use Primus\Tests\Constraint\AppliesFuncTo;
use Primus\Tests\Constraint\EqualsValue;

/**
 * @since 0.3
 */
final class FuncOfTest extends TestCase
{
    #[Test]
    public function appliesClosureToInput(): void
    {
        self::assertThat(
            new FuncOf(fn (int $x): int => $x * 2),
            new AppliesFuncTo(3, new EqualsValue(6)),
            'FuncOf must apply the closure to the input'
        );
    }
}
