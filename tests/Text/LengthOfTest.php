<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Text\LengthOf;
use Primus\Text\TextOf;

final class LengthOfTest extends TestCase
{
    #[Test]
    public function returnsLengthFiveWhenTextIsAscii(): void
    {
        $this->assertSame(
            5,
            new LengthOf(new TextOf('hello'))->value(),
            'Expected length 5 for ASCII string "hello"'
        );
    }

    #[Test]
    public function returnsLengthFiveWhenTextContainsDiacritics(): void
    {
        $this->assertSame(
            5,
            new LengthOf(new TextOf('àéîöü'))->value(),
            'Expected length 5 for multibyte string "àéîöü"'
        );
    }

    #[Test]
    public function returnsZeroWhenTextIsEmpty(): void
    {
        $this->assertSame(
            0,
            new LengthOf(new TextOf(''))->value(),
            'Expected length 0 for empty string'
        );
    }
}
