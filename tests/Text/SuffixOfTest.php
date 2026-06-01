<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\SuffixOf;
use Primus\Text\TextOf;

final class SuffixOfTest extends TestCase
{
    #[Test]
    public function returnsSegmentAfterBoundary(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::str('user@example.com'),
                TextOf::str('@'),
            ),
            new HasTextValue('example.com')
        );
    }

    #[Test]
    public function returnsEmptyWhenBoundaryAbsent(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::str('plainstring'),
                TextOf::str('@'),
            ),
            new HasTextValue('')
        );
    }

    #[Test]
    public function returnsEmptyWhenBoundaryAtEnd(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::str('head@'),
                TextOf::str('@'),
            ),
            new HasTextValue('')
        );
    }

    #[Test]
    public function startsAfterFirstBoundaryWhenMultiplePresent(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::str('a/b/c'),
                TextOf::str('/'),
            ),
            new HasTextValue('b/c')
        );
    }

    #[Test]
    public function preservesMultibyteCharactersAfterBoundary(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::str('café/мир'),
                TextOf::str('/'),
            ),
            new HasTextValue('мир')
        );
    }

    #[Test]
    public function findsMultibyteBoundaryAndAdvancesPastItByCodepoint(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::str('helloпривет'),
                TextOf::str('п'),
            ),
            new HasTextValue('ривет')
        );
    }

    #[Test]
    public function returnsEmptyForEmptyOrigin(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::str(''),
                TextOf::str('@'),
            ),
            new HasTextValue('')
        );
    }

    #[Test]
    public function textsFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('user@example.com');
        $boundary = TextOf::str('@');

        self::assertSame(
            (new SuffixOf($source, $boundary))->value(),
            SuffixOf::texts($source, $boundary)->value(),
        );
    }

    #[Test]
    public function stringsFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new SuffixOf(TextOf::str('user@example.com'), TextOf::str('@')))->value(),
            SuffixOf::strings('user@example.com', '@')->value(),
        );
    }
}
