<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Text\EndsWith;
use Primus\Text\TextOf;

final class EndsWithTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenHaystackEndsWithNeedle(): void
    {
        self::assertTrue(
            (new EndsWith(TextOf::str('hello world'), TextOf::str('world')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenHaystackDoesNotEndWithNeedle(): void
    {
        self::assertFalse(
            (new EndsWith(TextOf::str('hello world'), TextOf::str('hello')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsEmpty(): void
    {
        self::assertTrue(
            (new EndsWith(TextOf::str('hello'), TextOf::str('')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenNeedleIsLongerThanHaystack(): void
    {
        self::assertFalse(
            (new EndsWith(TextOf::str('hi'), TextOf::str('hello')))->value(),
        );
    }

    #[Test]
    public function returnsTrueOnExactMatch(): void
    {
        self::assertTrue(
            (new EndsWith(TextOf::str('abc'), TextOf::str('abc')))->value(),
        );
    }

    #[Test]
    public function respectsUtf8MultibyteCharacters(): void
    {
        self::assertTrue(
            (new EndsWith(TextOf::str('привет мир'), TextOf::str('мир')))->value(),
        );
    }

    #[Test]
    public function ofTextsFactoryAgreesWithPrimaryConstructor(): void
    {
        $haystack = TextOf::str('hello world');
        $needle = TextOf::str('world');

        self::assertSame(
            (new EndsWith($haystack, $needle))->value(),
            EndsWith::ofTexts($haystack, $needle)->value(),
        );
    }

    #[Test]
    public function ofStringsFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new EndsWith(TextOf::str('hello world'), TextOf::str('world')))->value(),
            EndsWith::ofStrings('hello world', 'world')->value(),
        );
    }
}
