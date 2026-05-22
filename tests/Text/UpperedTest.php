<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\TextOf;
use Primus\Text\Uppered;

final class UpperedTest extends TestCase
{
    #[Test]
    public function returnsUppercaseWhenTextIsLowercase(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('hello')),
            new HasTextValue('HELLO')
        );
    }

    #[Test]
    public function returnsUppercaseWhenTextIsMixedCase(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('HeLLo WoRLD')),
            new HasTextValue('HELLO WORLD')
        );
    }

    #[Test]
    public function returnsUppercaseWhenTextContainsDiacritics(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('àéîöü')),
            new HasTextValue('ÀÉÎÖÜ')
        );
    }

    #[Test]
    public function returnsEmptyStringWhenInputIsEmpty(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('')),
            new HasTextValue('')
        );
    }

    #[Test]
    public function returnsSameTextWhenAlreadyUppercase(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('ALREADY')),
            new HasTextValue('ALREADY')
        );
    }

    #[Test]
    public function leavesSpecialCharactersUnchanged(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('test@123!')),
            new HasTextValue('TEST@123!')
        );
    }

    #[Test]
    public function returnsSameWhenTextContainsOnlyWhitespace(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('   ')),
            new HasTextValue('   ')
        );
    }

    #[Test]
    public function ofStringUppercasesNativeString(): void
    {
        self::assertThat(
            Uppered::ofString('hello'),
            new HasTextValue('HELLO')
        );
    }

    #[Test]
    #[DataProvider('inputs')]
    public function ofStringAgreesWithTextFormOnEveryInput(string $input): void
    {
        self::assertSame(
            (new Uppered(TextOf::str($input)))->value(),
            Uppered::ofString($input)->value(),
        );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function inputs(): array
    {
        return [
            'empty string' => [''],
            'all lowercase' => ['hello'],
            'mixed case' => ['HeLLo WoRLD'],
            'diacritics' => ['àéîöü'],
            'already uppercase' => ['ALREADY'],
            'special characters' => ['test@123!'],
            'whitespace only' => ['   '],
            'cyrillic' => ['привет'],
        ];
    }
}
