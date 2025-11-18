<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Iterator;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Iterator\IteratorOf;
use Primus\Iterator\NoNulls;
use Primus\Tests\Constraint\HasIteratorValues;
use Primus\Tests\Constraint\ThrowsClosure;

/**
 * @since 0.5
 */
final class NoNullsTest extends TestCase
{
    #[Test]
    public function throwsWhenEncounteringNull(): void
    {
        $it = new NoNulls(new IteratorOf([1, null, 3]));
        $it->rewind();
        $it->next();

        self::assertThat(
            fn (): mixed => $it->current(),
            new ThrowsClosure(\RuntimeException::class),
        );
    }

    #[Test]
    public function returnsAllValuesWhenNoNullsPresent(): void
    {
        self::assertThat(
            new NoNulls(new IteratorOf([10, 20, 30])),
            new HasIteratorValues([10, 20, 30]),
        );
    }

    #[Test]
    public function throwsWhenFirstElementIsNull(): void
    {
        $it = new NoNulls(new IteratorOf([null, 5]));
        $it->rewind();

        self::assertThat(
            fn (): mixed => $it->current(),
            new ThrowsClosure(\RuntimeException::class),
        );
    }
}
