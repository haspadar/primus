<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Logic;

use Primus\Logic\IsUrl;
use Primus\Text\TextOf;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class IsUrlTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenTextIsValidUrl(): void
    {
        $this->assertTrue(
            new IsUrl(new TextOf('https://example.com'))->value(),
            'Expected true for valid URL "https://example.com"'
        );
    }

    #[Test]
    public function returnsFalseWhenTextIsInvalidUrl(): void
    {
        $this->assertFalse(
            new IsUrl(new TextOf('not-a-valid-url'))->value(),
            'Expected false for invalid URL "not-a-valid-url"'
        );
    }

    #[Test]
    public function returnsTrueForHttpUrl(): void
    {
        $this->assertTrue(
            new IsUrl(new TextOf('http://example.com'))->value(),
            'Expected true for HTTP URL'
        );
    }

    #[Test]
    public function returnsFalseForEmptyString(): void
    {
        $this->assertFalse(
            new IsUrl(new TextOf(''))->value(),
            'Expected false for empty string'
        );
    }
}
