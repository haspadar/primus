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
            (new Contains(TextOf::ofString('hello world'), TextOf::ofString('lo wo')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsAtStart(): void
    {
        self::assertTrue(
            (new Contains(TextOf::ofString('hello world'), TextOf::ofString('hello')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsAtEnd(): void
    {
        self::assertTrue(
            (new Contains(TextOf::ofString('hello world'), TextOf::ofString('world')))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenNeedleIsAbsent(): void
    {
        self::assertFalse(
            (new Contains(TextOf::ofString('hello world'), TextOf::ofString('xyz')))->value(),
        );
    }

    #[Test]
    public function returnsTrueWhenNeedleIsEmpty(): void
    {
        self::assertTrue(
            (new Contains(TextOf::ofString('hello'), TextOf::ofString('')))->value(),
        );
    }

    #[Test]
    public function respectsUtf8MultibyteCharacters(): void
    {
        self::assertTrue(
            (new Contains(TextOf::ofString('привет мир'), TextOf::ofString('ет ми')))->value(),
        );
    }
}
