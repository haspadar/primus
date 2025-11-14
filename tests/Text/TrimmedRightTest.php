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
use Primus\Text\TextOf;
use Primus\Text\TrimmedRight;

/**
 * @since 0.2
 */
final class TrimmedRightTest extends TestCase
{
    #[Test]
    public function removesTrailingSpacesOnly(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf('  hello world   ')),
            new HasTextValue('  hello world')
        );
    }

    #[Test]
    public function returnsSameTextWhenNoTrailingSpaces(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf('world')),
            new HasTextValue('world')
        );
    }

    #[Test]
    public function removesUnicodeWhitespace(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf("Hello  ")),
            new HasTextValue('Hello')
        );
    }

    #[Test]
    public function returnsEmptyWhenOnlySpaces(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf('   ')),
            new HasTextValue('')
        );
    }

    #[Test]
    public function keepsLeadingSpacesIntact(): void
    {
        self::assertThat(
            new TrimmedRight(new TextOf('  hi')),
            new HasTextValue('  hi')
        );
    }

    #[Test]
    public function throwsExceptionOnMalformedUtf8(): void
    {
        self::assertThat(
            (new TrimmedRight(new TextOf("\xC3"))),
            new Throws(InvalidArgumentException::class)
        );
    }
}
