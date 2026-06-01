<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Sub;
use Primus\Text\TextOf;

/**
 */
final class SubTest extends TestCase
{
    #[Test]
    public function returnsSubstringWithinRange(): void
    {
        self::assertThat(
            new Sub(TextOf::str('abcdefg'), 2, 3),
            new HasTextValue('cde')
        );
    }

    #[Test]
    public function returnsSubstringToEndWhenLengthNotLimited(): void
    {
        self::assertThat(
            new Sub(TextOf::str('abcdefg'), 3),
            new HasTextValue('defg')
        );
    }

    #[Test]
    public function handlesMultibyteEmojiCorrectly(): void
    {
        self::assertThat(
            new Sub(TextOf::str('😀bcdef'), 0, 2),
            new HasTextValue('😀b')
        );
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('hello world');

        self::assertSame(
            (new Sub($source, 0, 5))->value(),
            Sub::ofText($source, 0, 5)->value(),
        );
    }

    #[Test]
    public function ofStringFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new Sub(TextOf::str('hello world'), 0, 5))->value(),
            Sub::ofString('hello world', 0, 5)->value(),
        );
    }
}
