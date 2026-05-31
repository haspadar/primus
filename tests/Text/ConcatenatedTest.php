<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Concatenated;
use Primus\Text\Text;
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

    #[Test]
    public function ofStringsConcatenatesNativeStrings(): void
    {
        self::assertThat(
            Concatenated::ofStrings('hello, ', 'world'),
            new HasTextValue('hello, world')
        );
    }

    #[Test]
    public function ofStringsReturnsEmptyForNoArguments(): void
    {
        self::assertThat(
            Concatenated::ofStrings(),
            new HasTextValue('')
        );
    }

    #[Test]
    public function ofStringsPreservesMultibyteCharacters(): void
    {
        self::assertThat(
            Concatenated::ofStrings('café', ' & ', 'привет'),
            new HasTextValue('café & привет')
        );
    }

    #[Test]
    #[DataProvider('concatenatedInputs')]
    public function ofStringsAgreesWithTextFormOnEveryInput(array $parts): void
    {
        $texts = array_map(static fn(string $p): Text => TextOf::str($p), $parts);

        self::assertSame(
            (new Concatenated(...$texts))->value(),
            Concatenated::ofStrings(...$parts)->value(),
        );
    }

    /**
     * @return array<string, array{list<string>}>
     */
    public static function concatenatedInputs(): array
    {
        return [
            'empty parts' => [[]],
            'single part' => [['only']],
            'two parts' => [['hello, ', 'world']],
            'three parts' => [['a', 'b', 'c']],
            'multibyte parts' => [['café', ' & ', 'привет']],
            'empty string parts' => [['a', '', 'b']],
        ];
    }

    #[Test]
    public function ofTextsFactoryAgreesWithPrimaryConstructor(): void
    {
        $a = TextOf::str('hello, ');
        $b = TextOf::str('world');

        self::assertSame(
            (new Concatenated($a, $b))->value(),
            Concatenated::ofTexts($a, $b)->value(),
        );
    }

    #[Test]
    public function ofTextsFactoryAgreesWithPrimaryConstructorForNoParts(): void
    {
        self::assertSame(
            (new Concatenated())->value(),
            Concatenated::ofTexts()->value(),
        );
    }
}
