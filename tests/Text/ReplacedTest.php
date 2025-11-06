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
use Primus\Text\Replaced;
use Primus\Text\TextOf;

final class ReplacedTest extends TestCase
{
    #[Test]
    public function replacesSingleSubstring(): void
    {
        self::assertThat(
            new Replaced(new TextOf('Hello, world!'), 'world', 'friend'),
            new HasValue('Hello, friend!')
        );
    }

    #[Test]
    public function replacesMultipleSubstrings(): void
    {
        self::assertThat(
            new Replaced(
                new TextOf('<b>Hello & bye</b>'),
                ['<b>', '</b>', '&'],
                ['', '', 'and']
            ),
            new HasValue('Hello and bye')
        );
    }

    #[Test]
    public function returnsOriginalTextWhenNoMatches(): void
    {
        self::assertThat(
            new Replaced(new TextOf('unchanged'), 'zzz', 'xxx'),
            new HasValue('unchanged')
        );
    }

    #[Test]
    public function handlesEmptyText(): void
    {
        self::assertThat(
            new Replaced(new TextOf(''), 'a', 'b'),
            new HasValue('')
        );
    }
}
