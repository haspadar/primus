<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use Primus\Text\Lowercased;
use Primus\Text\TextOf;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class LowercasedTest extends TestCase
{
    #[Test]
    public function returnsLowercaseWhenTextIsUppercase(): void
    {
        $this->assertSame(
            'hello',
            new Lowercased(new TextOf('HELLO'))->value(),
            'Expected "HELLO" to be converted to "hello"'
        );
    }

    #[Test]
    public function returnsLowercaseWhenTextIsMixedCase(): void
    {
        $this->assertSame(
            'hello world',
            new Lowercased(new TextOf('HeLLo WoRLD'))->value(),
            'Expected "HeLLo WoRLD" to be converted to "hello world"'
        );
    }

    #[Test]
    public function returnsLowercaseWhenTextContainsDiacritics(): void
    {
        $this->assertSame(
            'àéîöü',
            new Lowercased(new TextOf('ÀÉÎÖÜ'))->value(),
            'Expected "ÀÉÎÖÜ" to be converted to "àéîöü"'
        );
    }
}
