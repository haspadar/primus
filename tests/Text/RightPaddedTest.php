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
use Primus\Text\RightPadded;
use Primus\Text\TextOf;

final class RightPaddedTest extends TestCase
{
    #[Test]
    public function returnsTextPaddedWithZerosToRight(): void
    {
        self::assertThat(
            new RightPadded(new TextOf('12'), 5, '0'),
            new HasValue('12000')
        );
    }

    #[Test]
    public function returnsTextPaddedWithSpacesToRight(): void
    {
        self::assertThat(
            new RightPadded(new TextOf('abc'), 6, ' '),
            new HasValue('abc   ')
        );
    }

    #[Test]
    public function returnsSameTextWhenLengthExceedsPadding(): void
    {
        self::assertThat(
            new RightPadded(new TextOf('foobar'), 4, '*'),
            new HasValue('foobar')
        );
    }

    #[Test]
    public function returnsPaddingOnlyWhenTextIsEmpty(): void
    {
        self::assertThat(
            new RightPadded(new TextOf(''), 3, '.'),
            new HasValue('...')
        );
    }
}
