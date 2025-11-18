<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterable;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterator\IteratorOf;
use Primus\Iterator\NoNulls;
use Primus\Tests\Constraint\HasIteratorValues;
use Primus\Tests\Constraint\ThrowsClosure;
use RuntimeException;

/**
 * @since 0.5
 */
final class NoNullsTest extends TestCase
{
    #[Test]
    public function throwsOnNullValue(): void
    {
        self::assertThat(
            function (): void {
                $it = new NoNulls(
                    new IteratorOf([1, null, 3])
                );
                $it->rewind();
                $it->next();
                $it->current();
            },
            new ThrowsClosure(RuntimeException::class)
        );
    }

    #[Test]
    public function iteratesOverNonNullValues(): void
    {
        self::assertThat(
            new NoNulls(
                new IteratorOf([1, 2])
            ),
            new HasIteratorValues([1, 2])
        );
    }

    #[Test]
    public function throwsOnNullAtFirstElement(): void
    {
        self::assertThat(
            function (): void {
                $it = new NoNulls(
                    new IteratorOf([null])
                );
                $it->rewind();
                $it->current();
            },
            new ThrowsClosure(RuntimeException::class)
        );
    }
}
