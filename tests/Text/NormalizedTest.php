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
use Primus\Text\Normalized;
use Primus\Text\TextOf;

final class NormalizedTest extends TestCase
{
    #[Test]
    public function replacesMultipleSpacesWithSingleOne(): void
    {
        self::assertThat(
            new Normalized(new TextOf('Hello   world')),
            new HasValue('Hello world')
        );
    }

    #[Test]
    public function replacesTabsAndNewlinesWithSingleSpace(): void
    {
        self::assertThat(
            new Normalized(new TextOf("A\tB\nC")),
            new HasValue('A B C')
        );
    }

    #[Test]
    public function trimsLeadingAndTrailingSpaces(): void
    {
        self::assertThat(
            new Normalized(new TextOf("   Hello world   ")),
            new HasValue('Hello world')
        );
    }

    #[Test]
    public function worksWithUnicodeWhitespace(): void
    {
        self::assertThat(
            new Normalized(new TextOf("α β  γ")),
            new HasValue('α β γ')
        );
    }

    #[Test]
    public function returnsEmptyStringWhenOnlyWhitespace(): void
    {
        self::assertThat(
            new Normalized(new TextOf(" \n\t ")),
            new HasValue('')
        );
    }
}
