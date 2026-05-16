<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Tests\Constraint\ThrowsValue;
use Primus\Text\Normalized;
use Primus\Text\TextOf;

/**
 */
final class NormalizedTest extends TestCase
{
    #[Test]
    public function replacesMultipleSpacesWithSingleOne(): void
    {
        self::assertThat(
            new Normalized(TextOf::ofString('Hello   world')),
            new HasTextValue('Hello world'),
            'Normalized must replace multiple spaces with a single one'
        );
    }

    #[Test]
    public function replacesTabsAndNewlinesWithSingleSpace(): void
    {
        self::assertThat(
            new Normalized(TextOf::ofString("A\tB\nC")),
            new HasTextValue('A B C'),
            'Normalized must replace tabs and newlines with a single space'
        );
    }

    #[Test]
    public function trimsLeadingAndTrailingSpaces(): void
    {
        self::assertThat(
            new Normalized(TextOf::ofString("   Hello world   ")),
            new HasTextValue('Hello world'),
            'Normalized must trim leading and trailing spaces'
        );
    }

    #[Test]
    public function worksWithUnicodeWhitespace(): void
    {
        self::assertThat(
            new Normalized(TextOf::ofString("α β  γ")),
            new HasTextValue('α β γ'),
            'Normalized must work with unicode whitespace'
        );
    }

    #[Test]
    public function returnsEmptyStringWhenOnlyWhitespace(): void
    {
        self::assertThat(
            new Normalized(TextOf::ofString(" \n\t ")),
            new HasTextValue(''),
            'Normalized must return an empty string when the original text consists only of whitespace'
        );
    }

    #[Test]
    public function throwsExceptionOnMalformedUtf8(): void
    {
        self::assertThat(
            new Normalized(TextOf::ofString("\xC3")),
            new ThrowsValue(InvalidArgumentException::class),
            'Normalized must throw an exception on malformed UTF-8 input'
        );
    }
}
