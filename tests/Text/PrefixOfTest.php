<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\PrefixOf;
use Primus\Text\TextOf;

final class PrefixOfTest extends TestCase
{
    #[Test]
    public function returnsSegmentBeforeBoundary(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::str('user@example.com'),
                TextOf::str('@'),
            ),
            new HasTextValue('user')
        );
    }

    #[Test]
    public function returnsOriginWhenBoundaryAbsent(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::str('plainstring'),
                TextOf::str('@'),
            ),
            new HasTextValue('plainstring')
        );
    }

    #[Test]
    public function returnsEmptyWhenBoundaryAtStart(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::str('@tail'),
                TextOf::str('@'),
            ),
            new HasTextValue('')
        );
    }

    #[Test]
    public function stopsAtFirstBoundaryWhenMultiplePresent(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::str('a/b/c'),
                TextOf::str('/'),
            ),
            new HasTextValue('a')
        );
    }

    #[Test]
    public function preservesMultibyteCharactersBeforeBoundary(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::str('café/мир'),
                TextOf::str('/'),
            ),
            new HasTextValue('café')
        );
    }

    #[Test]
    public function findsMultibyteBoundary(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::str('helloпривет'),
                TextOf::str('п'),
            ),
            new HasTextValue('hello')
        );
    }

    #[Test]
    public function returnsEmptyForEmptyOrigin(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::str(''),
                TextOf::str('@'),
            ),
            new HasTextValue('')
        );
    }
}
