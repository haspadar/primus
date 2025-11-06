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
use Primus\Text\LeftPadded;
use Primus\Text\TextOf;

final class LeftPaddedTest extends TestCase
{
    #[Test]
    public function padsTextOnLeft(): void
    {
        self::assertThat(
            new LeftPadded(new TextOf('foo'), 6, '.'),
            new HasValue('...foo')
        );
    }

    #[Test]
    public function returnsOriginalWhenLengthIsShorter(): void
    {
        self::assertThat(
            new LeftPadded(new TextOf('foobar'), 3, '.'),
            new HasValue('foobar')
        );
    }

    #[Test]
    public function padsWithSpacesByDefault(): void
    {
        self::assertThat(
            new LeftPadded(new TextOf('bar'), 6, ' '),
            new HasValue('   bar')
        );
    }

    #[Test]
    public function handlesEmptyText(): void
    {
        self::assertThat(
            new LeftPadded(new TextOf(''), 6, '.'),
            new HasValue('......')
        );
    }
}
