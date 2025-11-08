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
use Primus\Text\HtmlEscaped;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
final class HtmlEscapedTest extends TestCase
{
    #[Test]
    public function escapesSpecialCharacters(): void
    {
        self::assertThat(
            new HtmlEscaped(new TextOf('<b>John & "Jane"</b>')),
            new HasTextValue('&lt;b&gt;John &amp; &quot;Jane&quot;&lt;/b&gt;')
        );
    }

    #[Test]
    public function leavesPlainTextUntouched(): void
    {
        self::assertThat(
            new HtmlEscaped(new TextOf('Hello world')),
            new HasTextValue('Hello world')
        );
    }

    #[Test]
    public function handlesEmptyString(): void
    {
        self::assertThat(
            new HtmlEscaped(new TextOf('')),
            new HasTextValue('')
        );
    }
}
