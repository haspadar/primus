<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests\Logic;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Logic\IsNumeric;
use Primus\Text\TextOf;

final class IsNumericTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenTextIsInteger(): void
    {
        $this->assertTrue(
            new IsNumeric(new TextOf('123'))->value(),
            'Expected true for integer string "123"'
        );
    }

    #[Test]
    public function returnsTrueWhenTextIsFloat(): void
    {
        $this->assertTrue(
            new IsNumeric(new TextOf('3.14'))->value(),
            'Expected true for float string "3.14"'
        );
    }

    #[Test]
    public function returnsTrueWhenTextIsScientificNotation(): void
    {
        $this->assertTrue(
            new IsNumeric(new TextOf('1e10'))->value(),
            'Expected true for scientific notation string "1e10"'
        );
    }

    #[Test]
    public function returnsFalseWhenTextIsNotNumeric(): void
    {
        $this->assertFalse(
            new IsNumeric(new TextOf('abc'))->value(),
            'Expected false for non-numeric string "abc"'
        );
    }

    #[Test]
    public function returnsFalseWhenTextIsEmpty(): void
    {
        $this->assertFalse(
            new IsNumeric(new TextOf(''))->value(),
            'Expected false for empty string'
        );
    }

    #[Test]
    public function returnsFalseWhenTextContainsSpaces(): void
    {
        $this->assertFalse(
            new IsNumeric(new TextOf(' 123 '))->value(),
            'Expected false for string with spaces'
        );
    }

    #[Test]
    public function returnsTrueWhenTextIsNegativeNumber(): void
    {
        $this->assertTrue(
            new IsNumeric(new TextOf('-123'))->value(),
            'Expected true for negative number string'
        );
    }
}
