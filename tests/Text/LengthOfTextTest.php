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
use Primus\Tests\Constraint\HasSize;
use Primus\Text\LengthOfText;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
#[CoversClass(LengthOfText::class)]
final class LengthOfTextTest extends TestCase
{
    #[Test]
    public function returnsLengthFiveWhenTextIsAscii(): void
    {
        self::assertThat(
            new TextOf('hello'),
            new HasSize(5)
        );
    }

    #[Test]
    public function returnsLengthFiveWhenTextContainsDiacritics(): void
    {
        self::assertThat(
            new TextOf('àéîöü'),
            new HasSize(5)
        );
    }

    #[Test]
    public function returnsZeroWhenTextIsEmpty(): void
    {
        self::assertThat(
            new TextOf(''),
            new HasSize(0)
        );
    }
}
