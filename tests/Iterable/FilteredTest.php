<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterable\Filtered;
use Primus\Iterable\SequenceOf;

final class FilteredTest extends TestCase
{
    #[Test]
    public function keepsOnlyEvenNumbers(): void
    {
        $this->assertSame(
            [2, 4],
            iterator_to_array(
                new Filtered(
                    fn (int $x) => $x % 2 === 0,
                    new SequenceOf([1, 2, 3, 4])
                )
            ),
            'Expected to keep only even numbers'
        );
    }
}
