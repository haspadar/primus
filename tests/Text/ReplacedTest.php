<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Replaced;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
#[CoversClass(Replaced::class)]
final class ReplacedTest extends TestCase
{
    #[Test]
    public function replacesSingleSubstring(): void
    {
        self::assertThat(
            new Replaced(new TextOf('Hello, world!'), 'world', 'friend'),
            new HasTextValue('Hello, friend!')
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
            new HasTextValue('Hello and bye')
        );
    }

    #[Test]
    public function returnsOriginalTextWhenNoMatches(): void
    {
        self::assertThat(
            new Replaced(new TextOf('unchanged'), 'zzz', 'xxx'),
            new HasTextValue('unchanged')
        );
    }

    #[Test]
    public function handlesEmptyText(): void
    {
        self::assertThat(
            new Replaced(new TextOf(''), 'a', 'b'),
            new HasTextValue('')
        );
    }
}
