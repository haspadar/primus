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
                TextOf::ofString('user@example.com'),
                TextOf::ofString('@'),
            ),
            new HasTextValue('example.com')
        );
    }

    #[Test]
    public function returnsEmptyWhenBoundaryAbsent(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::ofString('plainstring'),
                TextOf::ofString('@'),
            ),
            new HasTextValue('')
        );
    }

    #[Test]
    public function returnsEmptyWhenBoundaryAtEnd(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::ofString('head@'),
                TextOf::ofString('@'),
            ),
            new HasTextValue('')
        );
    }

    #[Test]
    public function startsAfterFirstBoundaryWhenMultiplePresent(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::ofString('a/b/c'),
                TextOf::ofString('/'),
            ),
            new HasTextValue('b/c')
        );
    }

    #[Test]
    public function preservesMultibyteCharactersAfterBoundary(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::ofString('café/мир'),
                TextOf::ofString('/'),
            ),
            new HasTextValue('мир')
        );
    }

    #[Test]
    public function findsMultibyteBoundaryAndAdvancesPastItByCodepoint(): void
    {
        self::assertThat(
            new SuffixOf(
                TextOf::ofString('helloпривет'),
                TextOf::ofString('п'),
            ),
            new HasTextValue('ривет')
        );
    }
}
