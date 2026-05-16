<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Concatenated;
use Primus\Text\TextOf;

final class ConcatenatedTest extends TestCase
{
    #[Test]
    public function joinsTwoTextsInArgumentOrder(): void
    {
        self::assertThat(
            new Concatenated(
                TextOf::ofString('hello, '),
                TextOf::ofString('world'),
            ),
            new HasTextValue('hello, world')
        );
    }

    #[Test]
    public function joinsThreeTextsWithoutSeparator(): void
    {
        self::assertThat(
            new Concatenated(
                TextOf::ofString('a'),
                TextOf::ofString('b'),
                TextOf::ofString('c'),
            ),
            new HasTextValue('abc')
        );
    }

    #[Test]
    public function returnsEmptyForNoArguments(): void
    {
        self::assertThat(
            new Concatenated(),
            new HasTextValue('')
        );
    }

    #[Test]
    public function preservesMultibyteCharactersAcrossParts(): void
    {
        self::assertThat(
            new Concatenated(
                TextOf::ofString('café'),
                TextOf::ofString(' & '),
                TextOf::ofString('привет'),
            ),
            new HasTextValue('café & привет')
        );
    }

    #[Test]
    public function joinsSingleTextUnchanged(): void
    {
        self::assertThat(
            new Concatenated(TextOf::ofString('only')),
            new HasTextValue('only')
        );
    }
}
