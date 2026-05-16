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
            (new EndsWith(TextOf::ofString('hello world'), TextOf::ofString('world')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenHaystackDoesNotEndWithNeedle(): void
    {
        self::assertFalse(
            (new EndsWith(TextOf::ofString('hello world'), TextOf::ofString('hello')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsEmpty(): void
    {
        self::assertTrue(
            (new EndsWith(TextOf::ofString('hello'), TextOf::ofString('')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenNeedleIsLongerThanHaystack(): void
    {
        self::assertFalse(
            (new EndsWith(TextOf::ofString('hi'), TextOf::ofString('hello')))->value(),
        );
    }

    #[Test]
    public function returnsTrueOnExactMatch(): void
    {
        self::assertTrue(
            (new EndsWith(TextOf::ofString('abc'), TextOf::ofString('abc')))->value(),
        );
    }

    #[Test]
    public function respectsUtf8MultibyteCharacters(): void
    {
        self::assertTrue(
            (new EndsWith(TextOf::ofString('привет мир'), TextOf::ofString('мир')))->value(),
        );
    }
}
