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
use Primus\Text\TextOf;
use Primus\Text\TrimmedLeft;

final class TrimmedLeftTest extends TestCase
{
    #[Test]
    public function removesLeadingSpacesOnly(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf('   hello world  ')),
            new HasValue('hello world  ')
        );
    }

    #[Test]
    public function returnsSameTextWhenNoLeadingSpaces(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf('hello')),
            new HasValue('hello')
        );
    }

    #[Test]
    public function removesUnicodeWhitespace(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf("  Hello")), // em spaces (U+2003)
            new HasValue('Hello')
        );
    }

    #[Test]
    public function returnsEmptyWhenOnlySpaces(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf('   ')),
            new HasValue('')
        );
    }

    #[Test]
    public function keepsTrailingSpacesIntact(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf(' hi  ')),
            new HasValue('hi  ')
        );
    }
}
