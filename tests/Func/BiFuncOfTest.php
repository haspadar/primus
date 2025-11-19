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
use Primus\Tests\Constraint\AppliesBiFuncTo;

/**
 * @since 0.3
 */
final class BiFuncOfTest extends TestCase
{
    #[Test]
    public function appliesClosureToTwoInputs(): void
    {
        self::assertThat(
            new BiFuncOf(fn (int $a, int $b): int => $a + $b),
            new AppliesBiFuncTo([3, 4], 7),
            'BiFuncOf must apply the closure to two inputs'
        );
    }
}
