<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Text\Contains;
use Primus\Text\TextOf;

final class ContainsTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenNeedleIsInside(): void
    {
        self::assertTrue(
            (new Contains(TextOf::str('hello world'), TextOf::str('lo wo')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsAtStart(): void
    {
        self::assertTrue(
            (new Contains(TextOf::str('hello world'), TextOf::str('hello')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsAtEnd(): void
    {
        self::assertTrue(
            (new Contains(TextOf::str('hello world'), TextOf::str('world')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenNeedleIsAbsent(): void
    {
        self::assertFalse(
            (new Contains(TextOf::str('hello world'), TextOf::str('xyz')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsEmpty(): void
    {
        self::assertTrue(
            (new Contains(TextOf::str('hello'), TextOf::str('')))->value(),
        );
    }

    #[Test]
    public function respectsUtf8MultibyteCharacters(): void
    {
        self::assertTrue(
            (new Contains(TextOf::str('привет мир'), TextOf::str('ет ми')))->value(),
        );
    }
}
