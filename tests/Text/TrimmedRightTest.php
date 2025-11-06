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
use Primus\Text\TrimmedRight;

final class TrimmedRightTest extends TestCase
{
    #[Test]
    public function removesTrailingSpacesOnly(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf('  hello world   ')),
            new HasValue('  hello world')
        );
    }

    #[Test]
    public function returnsSameTextWhenNoTrailingSpaces(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf('world')),
            new HasValue('world')
        );
    }

    #[Test]
    public function removesUnicodeWhitespace(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf("Hello  ")), // em spaces (U+2003)
            new HasValue('Hello')
        );
    }

    #[Test]
    public function returnsEmptyWhenOnlySpaces(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf('   ')),
            new HasValue('')
        );
    }

    #[Test]
    public function keepsLeadingSpacesIntact(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf('  hi')),
            new HasValue('  hi')
        );
    }
}
