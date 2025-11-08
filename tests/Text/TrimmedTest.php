<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\TextOf;
use Primus\Text\Trimmed;

/**
 * @since 0.2
 */
final class TrimmedTest extends TestCase
{
    #[Test]
    public function returnsTextWithoutLeadingAndTrailingSpaces(): void
    {
        self::assertThat(
            new Trimmed(new TextOf('  hello  world  ')),
            new HasTextValue('hello  world')
        );
    }

    #[Test]
    public function returnsEmptyStringWhenInputIsWhitespaceOnly(): void
    {
        self::assertThat(
            new Trimmed(new TextOf('   ')),
            new HasTextValue('')
        );
    }
}
