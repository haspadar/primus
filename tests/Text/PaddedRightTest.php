<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Text\PaddedRight;
use Primus\Text\TextOf;

final class PaddedRightTest extends TestCase
{
    #[Test]
    public function returnsTextPaddedWithZerosToRight(): void
    {
        $this->assertSame(
            '12000',
            new PaddedRight(new TextOf('12'), 5, '0')->value(),
            'Expected "12" padded to "12000" with "0"'
        );
    }

    #[Test]
    public function returnsTextPaddedWithSpacesToRight(): void
    {
        $this->assertSame(
            'abc   ',
            new PaddedRight(new TextOf('abc'), 6, ' ')->value(),
            'Expected "abc" padded to "abc   " with spaces'
        );
    }

    #[Test]
    public function returnsSameTextWhenLengthExceedsPadding(): void
    {
        $this->assertSame(
            'foobar',
            new PaddedRight(new TextOf('foobar'), 4, '*')->value(),
            'Expected "foobar" to remain unchanged when already longer'
        );
    }

    #[Test]
    public function returnsPaddingOnlyWhenTextIsEmpty(): void
    {
        $this->assertSame(
            '...',
            new PaddedRight(new TextOf(''), 3, '.')->value(),
            'Expected empty string padded to "..." with "."'
        );
    }
}
