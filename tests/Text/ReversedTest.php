<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Reversed;
use Primus\Text\TextOf;

final class ReversedTest extends TestCase
{
    #[Test]
    public function returnsCharactersInReverseOrder(): void
    {
        self::assertThat(
            new Reversed(TextOf::str('hello')),
            new HasTextValue('olleh')
        );
    }

    #[Test]
    public function returnsEmptyForEmptyText(): void
    {
        self::assertThat(
            new Reversed(TextOf::str('')),
            new HasTextValue('')
        );
    }

    #[Test]
    public function preservesMultibyteCharactersAsWholeUnits(): void
    {
        self::assertThat(
            new Reversed(TextOf::str('café')),
            new HasTextValue('éfac')
        );
    }

    #[Test]
    public function reversesCyrillicTextByCodepoint(): void
    {
        self::assertThat(
            new Reversed(TextOf::str('привет')),
            new HasTextValue('тевирп')
        );
    }

    #[Test]
    public function reversesByCodepointNotGraphemeCluster(): void
    {
        self::assertThat(
            new Reversed(TextOf::str("cafe\u{0301}")),
            new HasTextValue("\u{0301}efac")
        );
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('café');

        self::assertSame(
            (new Reversed($source))->value(),
            Reversed::ofText($source)->value(),
        );
    }

    #[Test]
    public function ofStringFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new Reversed(TextOf::str('café')))->value(),
            Reversed::ofString('café')->value(),
        );
    }
}
