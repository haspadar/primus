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
use Primus\Text\Uppered;

final class UpperedTest extends TestCase
{
    #[Test]
    public function returnsUppercaseWhenTextIsLowercase(): void
    {
        self::assertThat(
            new Uppered(new TextOf('hello')),
            new HasValue('HELLO')
        );
    }

    #[Test]
    public function returnsUppercaseWhenTextIsMixedCase(): void
    {
        self::assertThat(
            new Uppered(new TextOf('HeLLo WoRLD')),
            new HasValue('HELLO WORLD')
        );
    }

    #[Test]
    public function returnsUppercaseWhenTextContainsDiacritics(): void
    {
        self::assertThat(
            new Uppered(new TextOf('àéîöü')),
            new HasValue('ÀÉÎÖÜ')
        );
    }
}
