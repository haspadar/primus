<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Sub;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
#[CoversClass(Sub::class)]
final class SubTest extends TestCase
{
    #[Test]
    public function returnsSubstringWithinRange(): void
    {
        self::assertThat(
            new Sub(new TextOf('abcdefg'), 2, 3),
            new HasTextValue('cde')
        );
    }

    #[Test]
    public function returnsSubstringToEndWhenLengthNotLimited(): void
    {
        self::assertThat(
            new Sub(new TextOf('abcdefg'), 3),
            new HasTextValue('defg')
        );
    }

    #[Test]
    public function handlesMultibyteEmojiCorrectly(): void
    {
        self::assertThat(
            new Sub(new TextOf('😀bcdef'), 0, 2),
            new HasTextValue('😀b')
        );
    }
}
