<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Capitalized;
use Primus\Text\TextOf;

final class CapitalizedTest extends TestCase
{
    #[Test]
    public function capitalizesFirstCharacter(): void
    {
        self::assertThat(
            new Capitalized(TextOf::str('hello')),
            new HasTextValue('Hello'),
            'Capitalized must capitalize the first character'
        );
    }

    #[Test]
    public function leavesAlreadyCapitalizedTextUnchanged(): void
    {
        self::assertThat(
            new Capitalized(TextOf::str('World')),
            new HasTextValue('World'),
            'Capitalized must leave already capitalized text unchanged'
        );
    }

    #[Test]
    public function worksWithMultibyteCharacters(): void
    {
        self::assertThat(
            new Capitalized(TextOf::str('ёлка')),
            new HasTextValue('Ёлка'),
            'Capitalized must work with multibyte characters'
        );
    }

    #[Test]
    public function returnsEmptyStringWhenInputIsEmpty(): void
    {
        self::assertThat(
            new Capitalized(TextOf::str('')),
            new HasTextValue(''),
            'Capitalized must return an empty string when the input is empty'
        );
    }

    #[Test]
    public function capitalizesOnlyFirstCharacter(): void
    {
        self::assertThat(
            new Capitalized(TextOf::str('hello WORLD')),
            new HasTextValue('Hello WORLD'),
            'Capitalized must capitalize only the first character'
        );
    }

    #[Test]
    public function ofStringCapitalisesNativeString(): void
    {
        self::assertThat(
            Capitalized::ofString('hello'),
            new HasTextValue('Hello')
        );
    }

    #[Test]
    #[DataProvider('inputs')]
    public function ofStringAgreesWithTextFormOnEveryInput(string $input): void
    {
        self::assertSame(
            (new Capitalized(TextOf::str($input)))->value(),
            Capitalized::ofString($input)->value(),
        );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function inputs(): array
    {
        return [
            'empty string' => [''],
            'lowercase word' => ['hello'],
            'already capitalised' => ['World'],
            'multibyte first char' => ['ёлка'],
            'mixed case after first' => ['hello WORLD'],
            'single char' => ['x'],
        ];
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('hello');

        self::assertSame(
            (new Capitalized($source))->value(),
            Capitalized::ofText($source)->value(),
        );
    }
}
