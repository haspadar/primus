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
                TextOf::ofString('user@example.com'),
                TextOf::ofString('@'),
            ),
            new HasTextValue('user')
        );
    }

    #[Test]
    public function returnsOriginWhenBoundaryAbsent(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::ofString('plainstring'),
                TextOf::ofString('@'),
            ),
            new HasTextValue('plainstring')
        );
    }

    #[Test]
    public function returnsEmptyWhenBoundaryAtStart(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::ofString('@tail'),
                TextOf::ofString('@'),
            ),
            new HasTextValue('')
        );
    }

    #[Test]
    public function stopsAtFirstBoundaryWhenMultiplePresent(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::ofString('a/b/c'),
                TextOf::ofString('/'),
            ),
            new HasTextValue('a')
        );
    }

    #[Test]
    public function preservesMultibyteCharactersBeforeBoundary(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::ofString('café/мир'),
                TextOf::ofString('/'),
            ),
            new HasTextValue('café')
        );
    }

    #[Test]
    public function findsMultibyteBoundary(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::ofString('helloпривет'),
                TextOf::ofString('п'),
            ),
            new HasTextValue('hello')
        );
    }

    #[Test]
    public function returnsEmptyForEmptyOrigin(): void
    {
        self::assertThat(
            new PrefixOf(
                TextOf::ofString(''),
                TextOf::ofString('@'),
            ),
            new HasTextValue('')
        );
    }
}
