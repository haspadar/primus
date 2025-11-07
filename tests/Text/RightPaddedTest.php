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
use Primus\Text\RightPadded;
use Primus\Text\TextOf;

/**
 * @since 0.2
 */
#[CoversClass(RightPadded::class)]
final class RightPaddedTest extends TestCase
{
    #[Test]
    public function returnsTextPaddedWithZerosToRight(): void
    {
        self::assertThat(
            new RightPadded(new TextOf('12'), 5, '0'),
            new HasTextValue('12000')
        );
    }

    #[Test]
    public function returnsTextPaddedWithSpacesToRight(): void
    {
        self::assertThat(
            new RightPadded(new TextOf('abc'), 6, ' '),
            new HasTextValue('abc   ')
        );
    }

    #[Test]
    public function returnsSameTextWhenLengthExceedsPadding(): void
    {
        self::assertThat(
            new RightPadded(new TextOf('foobar'), 4, '*'),
            new HasTextValue('foobar')
        );
    }

    #[Test]
    public function returnsPaddingOnlyWhenTextIsEmpty(): void
    {
        self::assertThat(
            new RightPadded(new TextOf(''), 3, '.'),
            new HasTextValue('...')
        );
    }
}
