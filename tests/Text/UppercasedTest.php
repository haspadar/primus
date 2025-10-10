<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use Primus\Text\TextOf;
use Primus\Text\Uppercased;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class UppercasedTest extends TestCase
{
    #[Test]
    public function returnsUppercaseWhenTextIsLowercase(): void
    {
        $this->assertSame(
            'HELLO',
            new Uppercased(new TextOf('hello'))->value(),
            'Expected "hello" to be converted to "HELLO"'
        );
    }

    #[Test]
    public function returnsUppercaseWhenTextIsMixedCase(): void
    {
        $this->assertSame(
            'HELLO WORLD',
            new Uppercased(new TextOf('HeLLo WoRLD'))->value(),
            'Expected "HeLLo WoRLD" to be converted to "HELLO WORLD"'
        );
    }

    #[Test]
    public function returnsUppercaseWhenTextContainsDiacritics(): void
    {
        $this->assertSame(
            'ÀÉÎÖÜ',
            new Uppercased(new TextOf('àéîöü'))->value(),
            'Expected "àéîöü" to be converted to "ÀÉÎÖÜ"'
        );
    }
}
