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
use Primus\Text\Abbreviated;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
final class AbbreviatedTest extends TestCase
{
    #[Test]
    public function returnsOriginalTextWhenLengthIsLessThanLimit(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('short'), 10),
            new HasTextValue('short'),
            'Abbreviated must return the original text when the length is less than the limit'
        );
    }

    #[Test]
    public function returnsOriginalTextWhenLengthEqualsLimit(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('exactly10!'), 10),
            new HasTextValue('exactly10!'),
            'Abbreviated must return the original text when the length equals the limit'
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenTextExceedsLimit(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('this is a long string'), 10),
            new HasTextValue('this is a…'),
            'Abbreviated must return truncated text with ellipsis when the text exceeds the limit'
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenTextContainsMultibyteCharacters(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('emoji 😊 test ok'), 8),
            new HasTextValue('emoji 😊…'),
            'Abbreviated must return truncated text with ellipsis when the text contains multibyte characters'
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenDefaultLimitIsApplied(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf(str_repeat('a', 100))),
            new HasTextValue(str_repeat('a', 49) . '…'),
            'Abbreviated must return truncated text with ellipsis when the default limit is applied'
        );
    }

    #[Test]
    public function returnsOnlyEllipsisWhenLimitIsOne(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('abcdef'), 1),
            new HasTextValue('…'),
            'Abbreviated must return only ellipsis when the limit is one'
        );
    }

    #[Test]
    public function returnsEmptyStringWhenLimitIsZero(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('abcdef'), 0),
            new HasTextValue(''),
            'Abbreviated must return an empty string when the limit is zero'
        );
    }
}
