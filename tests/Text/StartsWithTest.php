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
            (new StartsWith(TextOf::str('hello world'), TextOf::str('hello')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenHaystackDoesNotStartWithNeedle(): void
    {
        self::assertFalse(
            (new StartsWith(TextOf::str('hello world'), TextOf::str('world')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsEmpty(): void
    {
        self::assertTrue(
            (new StartsWith(TextOf::str('hello'), TextOf::str('')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenNeedleIsLongerThanHaystack(): void
    {
        self::assertFalse(
            (new StartsWith(TextOf::str('hi'), TextOf::str('hello')))->value(),
        );
    }

    #[Test]
    public function returnsTrueOnExactMatch(): void
    {
        self::assertTrue(
            (new StartsWith(TextOf::str('abc'), TextOf::str('abc')))->value(),
        );
    }

    #[Test]
    public function respectsUtf8MultibyteCharacters(): void
    {
        self::assertTrue(
            (new StartsWith(TextOf::str('привет мир'), TextOf::str('привет')))->value(),
        );
    }
}
