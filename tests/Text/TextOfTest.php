<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use Primus\Text\TextOf;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TextOfTest extends TestCase
{
    #[Test]
    public function returnsOriginalTextWhenValueIsRequested(): void
    {
        $this->assertSame(
            'hello',
            new TextOf('hello')->value(),
            'Expected TextOf to return original string "hello"'
        );
    }

    #[Test]
    public function castsToStringCorrectly(): void
    {
        $this->assertSame(
            'world',
            (string) new TextOf('world'),
            'Expected TextOf to cast to "world"'
        );
    }
}
