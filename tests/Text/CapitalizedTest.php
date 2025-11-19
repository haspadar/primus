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
use Primus\Text\Capitalized;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
final class CapitalizedTest extends TestCase
{
    #[Test]
    public function capitalizesFirstCharacter(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('hello')),
            new HasTextValue('Hello'),
            'Capitalized must capitalize the first character'
        );
    }

    #[Test]
    public function leavesAlreadyCapitalizedTextUnchanged(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('World')),
            new HasTextValue('World'),
            'Capitalized must leave already capitalized text unchanged'
        );
    }

    #[Test]
    public function worksWithMultibyteCharacters(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('ёлка')),
            new HasTextValue('Ёлка'),
            'Capitalized must work with multibyte characters'
        );
    }

    #[Test]
    public function returnsEmptyStringWhenInputIsEmpty(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('')),
            new HasTextValue(''),
            'Capitalized must return an empty string when the input is empty'
        );
    }

    #[Test]
    public function capitalizesOnlyFirstCharacter(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('hello WORLD')),
            new HasTextValue('Hello WORLD'),
            'Capitalized must capitalize only the first character'
        );
    }
}
