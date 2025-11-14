<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Tests\Constraint\Throws;
use Primus\Text\Normalized;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
final class NormalizedTest extends TestCase
{
    #[Test]
    public function replacesMultipleSpacesWithSingleOne(): void
    {
        self::assertThat(
            new Normalized(new TextOf('Hello   world')),
            new HasTextValue('Hello world')
        );
    }

    #[Test]
    public function replacesTabsAndNewlinesWithSingleSpace(): void
    {
        self::assertThat(
            new Normalized(new TextOf("A\tB\nC")),
            new HasTextValue('A B C')
        );
    }

    #[Test]
    public function trimsLeadingAndTrailingSpaces(): void
    {
        self::assertThat(
            new Normalized(new TextOf("   Hello world   ")),
            new HasTextValue('Hello world')
        );
    }

    #[Test]
    public function worksWithUnicodeWhitespace(): void
    {
        self::assertThat(
            new Normalized(new TextOf("α β  γ")),
            new HasTextValue('α β γ')
        );
    }

    #[Test]
    public function returnsEmptyStringWhenOnlyWhitespace(): void
    {
        self::assertThat(
            new Normalized(new TextOf(" \n\t ")),
            new HasTextValue('')
        );
    }

    #[Test]
    public function throwsExceptionOnMalformedUtf8(): void
    {
        self::assertThat(
            new Normalized(new TextOf("\xC3")),
            new Throws(InvalidArgumentException::class)
        );
    }
}
