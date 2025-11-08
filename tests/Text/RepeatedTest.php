<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Repeated;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
final class RepeatedTest extends TestCase
{
    #[Test]
    public function repeatsTextMultipleTimes(): void
    {
        self::assertThat(
            new Repeated(new TextOf('xo'), 3),
            new HasTextValue('xoxoxo')
        );
    }

    #[Test]
    public function returnsEmptyWhenCountIsZero(): void
    {
        self::assertThat(
            new Repeated(new TextOf('abc'), 0),
            new HasTextValue('')
        );
    }

    #[Test]
    public function returnsEmptyWhenCountIsNegative(): void
    {
        self::assertThat(
            new Repeated(new TextOf('abc'), -2),
            new HasTextValue('')
        );
    }

    #[Test]
    public function repeatsEmptyText(): void
    {
        self::assertThat(
            new Repeated(new TextOf(''), 5),
            new HasTextValue('')
        );
    }

    #[Test]
    public function repeatsSingleCharacter(): void
    {
        self::assertThat(
            new Repeated(new TextOf('a'), 5),
            new HasTextValue('aaaaa')
        );
    }

    #[Test]
    public function repeatsUnicodeText(): void
    {
        self::assertThat(
            new Repeated(new TextOf('🔥'), 3),
            new HasTextValue('🔥🔥🔥')
        );
    }
}
