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
use Primus\Text\TextOf;
use Primus\Text\WithoutTags;

final class WithoutTagsTest extends TestCase
{
    #[Test]
    public function returnsSanitizedTextWhenHtmlTagsArePresent(): void
    {
        self::assertThat(
            new WithoutTags(new TextOf('<script>alert("XSS")</script><b>bold</b> & "quote"')),
            new HasValue('alert("XSS")bold & "quote"')
        );
    }

    #[Test]
    public function returnsSameTextWhenInputIsPlain(): void
    {
        self::assertThat(
            new WithoutTags(new TextOf('safe text 123')),
            new HasValue('safe text 123')
        );
    }
}
