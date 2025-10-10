<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use Primus\Text\Preview;
use Primus\Text\TextOf;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PreviewTest extends TestCase
{
    #[Test]
    public function returnsOriginalTextWhenLengthIsLessThanLimit(): void
    {
        $this->assertSame(
            'short',
            new Preview(new TextOf('short'), 10)->value(),
            'Expected original text "short" when under limit'
        );
    }

    #[Test]
    public function returnsOriginalTextWhenLengthEqualsLimit(): void
    {
        $this->assertSame(
            'exactly10!',
            new Preview(new TextOf('exactly10!'), 10)->value(),
            'Expected original text "exactly10!" when equal to limit'
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenTextExceedsLimit(): void
    {
        $this->assertSame(
            'this is a…',
            new Preview(new TextOf('this is a long string'), 10)->value(),
            'Expected "this is a…" when input exceeds limit'
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenTextContainsMultibyteCharacters(): void
    {
        $this->assertSame(
            'Вітаю…',
            new Preview(new TextOf('Вітаю, даражэнькі'), 6)->value(),
            'Expected "Вітаю…" for multibyte input with limit 6'
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenDefaultLimitIsApplied(): void
    {
        $this->assertSame(
            str_repeat('a', 49) . '…',
            new Preview(new TextOf(str_repeat('a', 100)))->value(),
            'Expected 49 "a" + ellipsis when using default limit'
        );
    }

    #[Test]
    public function returnsOnlyEllipsisWhenLimitIsOne(): void
    {
        $this->assertSame(
            '…',
            new Preview(new TextOf('abcdef'), 1)->value(),
            'Expected only ellipsis when limit is 1'
        );
    }

    #[Test]
    public function returnsEmptyStringWhenLimitIsZero(): void
    {
        $this->assertSame(
            '',
            new Preview(new TextOf('abcdef'), 0)->value(),
            'Expected empty string when limit is 0'
        );
    }
}
