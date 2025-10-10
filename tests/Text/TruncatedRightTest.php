<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Text;

use Primus\Exception;
use Primus\Text\TextOf;
use Primus\Text\TruncatedRight;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TruncatedRightTest extends TestCase
{
    #[Test]
    public function returnsTruncatedTextWhenLengthExceedsLimit(): void
    {
        $this->assertSame(
            'abc',
            new TruncatedRight(new TextOf('abcdef'), 3)->value(),
            'Expected text "abcdef" to be truncated to "abc"'
        );
    }

    #[Test]
    public function returnsOriginalTextWhenLengthIsBelowLimit(): void
    {
        $this->assertSame(
            'abc',
            new TruncatedRight(new TextOf('abc'), 5)->value(),
            'Expected text "abc" to remain unchanged when under limit'
        );
    }

    #[Test]
    public function returnsEmptyStringWhenInputIsEmpty(): void
    {
        $this->assertSame(
            '',
            new TruncatedRight(new TextOf(''), 5)->value(),
            'Expected empty string when input is empty'
        );
    }

    #[Test]
    public function returnsEmptyStringWhenLimitIsZero(): void
    {
        $this->assertSame(
            '',
            new TruncatedRight(new TextOf('abc'), 0)->value(),
            'Expected empty string when limit is zero'
        );
    }

    #[Test]
    public function throwsWhenLengthIsNegative(): void
    {
        $this->expectException(Exception::class);
        new TruncatedRight(new TextOf('abc'), -1);
    }
}
