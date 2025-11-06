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
use Primus\Text\Capitalized;
use Primus\Text\TextOf;

final class CapitalizedTest extends TestCase
{
    #[Test]
    public function capitalizesFirstCharacter(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('hello')),
            new HasValue('Hello')
        );
    }

    #[Test]
    public function leavesAlreadyCapitalizedTextUnchanged(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('World')),
            new HasValue('World')
        );
    }

    #[Test]
    public function worksWithMultibyteCharacters(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('ёлка')),
            new HasValue('Ёлка')
        );
    }

    #[Test]
    public function returnsEmptyStringWhenInputIsEmpty(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('')),
            new HasValue('')
        );
    }

    #[Test]
    public function capitalizesOnlyFirstCharacter(): void
    {
        self::assertThat(
            new Capitalized(new TextOf('hello WORLD')),
            new HasValue('Hello WORLD')
        );
    }
}
