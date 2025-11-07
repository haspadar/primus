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
use Primus\Text\Lowered;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
#[CoversClass(Lowered::class)]
final class LoweredTest extends TestCase
{
    #[Test]
    public function returnsLowercaseWhenTextIsUppercase(): void
    {
        self::assertThat(
            new Lowered(new TextOf('HELLO')),
            new HasTextValue('hello')
        );
    }

    #[Test]
    public function returnsLowercaseWhenTextIsMixedCase(): void
    {
        self::assertThat(
            new Lowered(new TextOf('HeLLo WoRLD')),
            new HasTextValue('hello world')
        );
    }

    #[Test]
    public function returnsLowercaseWhenTextContainsDiacritics(): void
    {
        self::assertThat(
            new Lowered(new TextOf('ÀÉÎÖÜ')),
            new HasTextValue('àéîöü')
        );
    }
}
