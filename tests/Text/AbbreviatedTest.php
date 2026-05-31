<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Abbreviated;
use Primus\Text\TextOf;

/**
 */
final class AbbreviatedTest extends TestCase
{
    #[Test]
    public function returnsOriginalTextWhenLengthIsLessThanLimit(): void
    {
        self::assertThat(
            new Abbreviated(TextOf::str('short'), 10),
            new HasTextValue('short'),
            'Abbreviated must return the original text when the length is less than the limit'
        );
    }

    #[Test]
    public function returnsOriginalTextWhenLengthEqualsLimit(): void
    {
        self::assertThat(
            new Abbreviated(TextOf::str('exactly10!'), 10),
            new HasTextValue('exactly10!'),
            'Abbreviated must return the original text when the length equals the limit'
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenTextExceedsLimit(): void
    {
        self::assertThat(
            new Abbreviated(TextOf::str('this is a long string'), 10),
            new HasTextValue('this is a…'),
            'Abbreviated must return truncated text with ellipsis when the text exceeds the limit'
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenTextContainsMultibyteCharacters(): void
    {
        self::assertThat(
            new Abbreviated(TextOf::str('emoji 😊 test ok'), 8),
            new HasTextValue('emoji 😊…'),
            'Abbreviated must return truncated text with ellipsis when the text contains multibyte characters'
        );
    }

    #[Test]
    public function returnsTruncatedTextWithEllipsisWhenDefaultLimitIsApplied(): void
    {
        self::assertThat(
            new Abbreviated(TextOf::str(str_repeat('a', 100))),
            new HasTextValue(str_repeat('a', 49) . '…'),
            'Abbreviated must return truncated text with ellipsis when the default limit is applied'
        );
    }

    #[Test]
    public function returnsOnlyEllipsisWhenLimitIsOne(): void
    {
        self::assertThat(
            new Abbreviated(TextOf::str('abcdef'), 1),
            new HasTextValue('…'),
            'Abbreviated must return only ellipsis when the limit is one'
        );
    }

    #[Test]
    public function returnsEmptyStringWhenLimitIsZero(): void
    {
        self::assertThat(
            new Abbreviated(TextOf::str('abcdef'), 0),
            new HasTextValue(''),
            'Abbreviated must return an empty string when the limit is zero'
        );
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('Hello, world!');

        self::assertSame(
            (new Abbreviated($source, 8))->value(),
            Abbreviated::ofText($source, 8)->value(),
        );
    }

    #[Test]
    public function ofStringFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new Abbreviated(TextOf::str('Hello, world!'), 8))->value(),
            Abbreviated::ofString('Hello, world!', 8)->value(),
        );
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructorForDefaultLimit(): void
    {
        $source = TextOf::str('short');

        self::assertSame(
            (new Abbreviated($source))->value(),
            Abbreviated::ofText($source)->value(),
        );
    }
}
