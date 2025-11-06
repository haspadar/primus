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

final class TextOfTest extends TestCase
{
    #[Test]
    public function returnsOriginalTextWhenValueIsRequested(): void
    {
        self::assertThat(
            new TextOf('hello'),
            new HasValue('hello')
        );
    }

    #[Test]
    public function castsToStringCorrectly(): void
    {
        self::assertThat(
            new TextOf('world'),
            new HasValue((string) 'world')
        );
    }
}
