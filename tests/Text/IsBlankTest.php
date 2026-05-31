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
        self::assertTrue((new IsBlank(TextOf::str('')))->value());
    }

    #[Test]
    public function returnsTrueForAsciiSpacesOnly(): void
    {
        self::assertTrue((new IsBlank(TextOf::str('   ')))->value());
    }

    #[Test]
    public function returnsTrueForMixedAsciiWhitespace(): void
    {
        self::assertTrue((new IsBlank(TextOf::str(" \t\n\r")))->value());
    }

    #[Test]
    public function returnsTrueForUnicodeNonBreakingSpace(): void
    {
        self::assertTrue((new IsBlank(TextOf::str("\u{00A0}\u{2003}")))->value());
    }

    #[Test]
    public function returnsTrueForUnicodeLineAndParagraphSeparators(): void
    {
        self::assertTrue((new IsBlank(TextOf::str("\u{2028}\u{2029}")))->value());
    }

    #[Test]
    public function returnsFalseForNonBlankString(): void
    {
        self::assertFalse((new IsBlank(TextOf::str('hello')))->value());
    }

    #[Test]
    public function returnsFalseWhenContentSurroundedByWhitespace(): void
    {
        self::assertFalse((new IsBlank(TextOf::str('  x  ')))->value());
    }

    #[Test]
    public function returnsFalseForVisibleUtf8(): void
    {
        self::assertFalse((new IsBlank(TextOf::str('привет')))->value());
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str(" \t\n");

        self::assertSame(
            (new IsBlank($source))->value(),
            IsBlank::ofText($source)->value(),
        );
    }

    #[Test]
    public function ofStringFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new IsBlank(TextOf::str(" \t\n")))->value(),
            IsBlank::ofString(" \t\n")->value(),
        );
    }
}
