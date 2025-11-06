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
use Primus\Text\Abbreviated;
use Primus\Text\TextOf;

final class AbbreviatedTest extends TestCase
{
    #[Test]
    public function returnsOriginalTextWhenLengthIsLessThanLimit(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('short'), 10),
            new HasValue('short')
        );
    }

    #[Test]
    public function returnsOriginalTextWhenLengthEqualsLimit(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('exactly10!'), 10),
            new HasValue('exactly10!')
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenTextExceedsLimit(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('this is a long string'), 10),
            new HasValue('this is a…')
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenTextContainsMultibyteCharacters(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('emoji 😊 test ok'), 8),
            new HasValue('emoji 😊…')
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenDefaultLimitIsApplied(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf(str_repeat('a', 100))),
            new HasValue(str_repeat('a', 49) . '…')
        );
    }

    #[Test]
    public function returnsOnlyEllipsisWhenLimitIsOne(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('abcdef'), 1),
            new HasValue('…')
        );
    }

    #[Test]
    public function returnsEmptyStringWhenLimitIsZero(): void
    {
        self::assertThat(
            new Abbreviated(new TextOf('abcdef'), 0),
            new HasValue('')
        );
    }
}
