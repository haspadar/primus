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
use Primus\Text\TextOf;
use Primus\Text\TrimmedLeft;

/**
 * @since 0.2
 */
final class TrimmedLeftTest extends TestCase
{
    #[Test]
    public function removesLeadingSpacesOnly(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf('   hello world  ')),
            new HasTextValue('hello world  '),
            'TrimmedLeft must remove leading spaces only'
        );
    }

    #[Test]
    public function returnsSameTextWhenNoLeadingSpaces(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf('hello')),
            new HasTextValue('hello'),
            'TrimmedLeft must return the same text when there are no leading spaces'
        );
    }

    #[Test]
    public function removesUnicodeWhitespace(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf("  Hello")), // em spaces (U+2003)
            new HasTextValue('Hello'),
            'TrimmedLeft must remove unicode whitespace'
        );
    }

    #[Test]
    public function returnsEmptyWhenOnlySpaces(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf('   ')),
            new HasTextValue(''),
            'TrimmedLeft must return an empty string when the original text consists only of spaces'
        );
    }

    #[Test]
    public function keepsTrailingSpacesIntact(): void
    {
        self::assertThat(
            new TrimmedLeft(new TextOf(' hi  ')),
            new HasTextValue('hi  '),
            'TrimmedLeft must keep trailing spaces intact'
        );
    }
}
