<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Lowered;
use Primus\Text\TextOf;

final class LoweredTest extends TestCase
{
    #[Test]
    public function returnsLowercaseWhenTextIsUppercase(): void
    {
        self::assertThat(
            new Lowered(TextOf::str('HELLO')),
            new HasTextValue('hello')
        );
    }

    #[Test]
    public function returnsLowercaseWhenTextIsMixedCase(): void
    {
        self::assertThat(
            new Lowered(TextOf::str('HeLLo WoRLD')),
            new HasTextValue('hello world')
        );
    }

    #[Test]
    public function returnsLowercaseWhenTextContainsDiacritics(): void
    {
        self::assertThat(
            new Lowered(TextOf::str('ÀÉÎÖÜ')),
            new HasTextValue('àéîöü')
        );
    }

    #[Test]
    public function ofStringLowercasesNativeString(): void
    {
        self::assertThat(
            Lowered::ofString('HELLO'),
            new HasTextValue('hello')
        );
    }

    #[Test]
    #[DataProvider('inputs')]
    public function ofStringAgreesWithTextFormOnEveryInput(string $input): void
    {
        self::assertSame(
            (new Lowered(TextOf::str($input)))->value(),
            Lowered::ofString($input)->value(),
        );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function inputs(): array
    {
        return [
            'empty string' => [''],
            'all uppercase' => ['HELLO'],
            'mixed case' => ['HeLLo WoRLD'],
            'diacritics' => ['ÀÉÎÖÜ'],
            'already lowercase' => ['café'],
            'cyrillic' => ['ПРИВЕТ'],
        ];
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('CAFÉ');

        self::assertSame(
            (new Lowered($source))->value(),
            Lowered::ofText($source)->value(),
        );
    }
}
