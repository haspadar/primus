<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Text\StartsWith;
use Primus\Text\TextOf;

final class StartsWithTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenHaystackStartsWithNeedle(): void
    {
        self::assertTrue(
            (new StartsWith(TextOf::ofString('hello world'), TextOf::ofString('hello')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenHaystackDoesNotStartWithNeedle(): void
    {
        self::assertFalse(
            (new StartsWith(TextOf::ofString('hello world'), TextOf::ofString('world')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsEmpty(): void
    {
        self::assertTrue(
            (new StartsWith(TextOf::ofString('hello'), TextOf::ofString('')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenNeedleIsLongerThanHaystack(): void
    {
        self::assertFalse(
            (new StartsWith(TextOf::ofString('hi'), TextOf::ofString('hello')))->value(),
        );
    }

    #[Test]
    public function returnsTrueOnExactMatch(): void
    {
        self::assertTrue(
            (new StartsWith(TextOf::ofString('abc'), TextOf::ofString('abc')))->value(),
        );
    }

    #[Test]
    public function respectsUtf8MultibyteCharacters(): void
    {
        self::assertTrue(
            (new StartsWith(TextOf::ofString('привет мир'), TextOf::ofString('привет')))->value(),
        );
    }
}
