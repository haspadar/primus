<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\Filtered;
use Primus\Iterable\SequenceOf;
use Primus\Tests\Constraint\HasScalarValues;

/**
 * @since 0.2
 */
#[CoversClass(Filtered::class)]
final class FilteredTest extends TestCase
{
    #[Test]
    public function keepsOnlyEvenNumbers(): void
    {
        self::assertThat(
            new Filtered(fn (int $x) => $x % 2 === 0, new SequenceOf([1, 2, 3, 4])),
            new HasScalarValues([2, 4])
        );
    }
}
