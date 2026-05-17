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
                TextOf::str('hello, '),
                TextOf::str('world'),
            ),
            new HasTextValue('hello, world')
        );
    }

    #[Test]
    public function joinsThreeTextsWithoutSeparator(): void
    {
        self::assertThat(
            new Concatenated(
                TextOf::str('a'),
                TextOf::str('b'),
                TextOf::str('c'),
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
                TextOf::str('café'),
                TextOf::str(' & '),
                TextOf::str('привет'),
            ),
            new HasTextValue('café & привет')
        );
    }

    #[Test]
    public function joinsSingleTextUnchanged(): void
    {
        self::assertThat(
            new Concatenated(TextOf::str('only')),
            new HasTextValue('only')
        );
    }
}
