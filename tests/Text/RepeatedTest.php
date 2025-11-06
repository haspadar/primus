<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasValue;
use Primus\Text\Repeated;
use Primus\Text\TextOf;

final class RepeatedTest extends TestCase
{
    #[Test]
    public function repeatsTextMultipleTimes(): void
    {
        self::assertThat(
            new Repeated(new TextOf('xo'), 3),
            new HasValue('xoxoxo')
        );
    }

    #[Test]
    public function returnsEmptyWhenCountIsZero(): void
    {
        self::assertThat(
            new Repeated(new TextOf('abc'), 0),
            new HasValue('')
        );
    }

    #[Test]
    public function returnsEmptyWhenCountIsNegative(): void
    {
        self::assertThat(
            new Repeated(new TextOf('abc'), -2),
            new HasValue('')
        );
    }

    #[Test]
    public function repeatsEmptyText(): void
    {
        self::assertThat(
            new Repeated(new TextOf(''), 5),
            new HasValue('')
        );
    }

    #[Test]
    public function repeatsSingleCharacter(): void
    {
        self::assertThat(
            new Repeated(new TextOf('a'), 5),
            new HasValue('aaaaa')
        );
    }
}
