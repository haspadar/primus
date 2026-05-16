<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Text\IsBlank;
use Primus\Text\TextOf;

final class IsBlankTest extends TestCase
{
    #[Test]
    public function returnsTrueForEmptyString(): void
    {
        self::assertTrue((new IsBlank(TextOf::ofString('')))->value());
    }

    #[Test]
    public function returnsTrueForAsciiSpacesOnly(): void
    {
        self::assertTrue((new IsBlank(TextOf::ofString('   ')))->value());
    }

    #[Test]
    public function returnsTrueForMixedAsciiWhitespace(): void
    {
        self::assertTrue((new IsBlank(TextOf::ofString(" \t\n\r")))->value());
    }

    #[Test]
    public function returnsTrueForUnicodeNonBreakingSpace(): void
    {
        self::assertTrue((new IsBlank(TextOf::ofString("\u{00A0}\u{2003}")))->value());
    }

    #[Test]
    public function returnsTrueForUnicodeLineAndParagraphSeparators(): void
    {
        self::assertTrue((new IsBlank(TextOf::ofString("\u{2028}\u{2029}")))->value());
    }

    #[Test]
    public function returnsFalseForNonBlankString(): void
    {
        self::assertFalse((new IsBlank(TextOf::ofString('hello')))->value());
    }

    #[Test]
    public function returnsFalseWhenContentSurroundedByWhitespace(): void
    {
        self::assertFalse((new IsBlank(TextOf::ofString('  x  ')))->value());
    }

    #[Test]
    public function returnsFalseForVisibleUtf8(): void
    {
        self::assertFalse((new IsBlank(TextOf::ofString('привет')))->value());
    }
}
