<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\FormattedText;
use Primus\Text\TextOf;

final class FormattedTextTest extends TestCase
{
    #[Test]
    public function substitutesStringArgument(): void
    {
        self::assertThat(
            new FormattedText(TextOf::str('Hello, %s!'), 'world'),
            new HasTextValue('Hello, world!')
        );
    }

    #[Test]
    public function substitutesIntAndFloatArguments(): void
    {
        self::assertThat(
            new FormattedText(TextOf::str('%d items at %.2f each'), 5, 3.5),
            new HasTextValue('5 items at 3.50 each')
        );
    }

    #[Test]
    public function returnsPatternUnchangedWhenNoPlaceholders(): void
    {
        self::assertThat(
            new FormattedText(TextOf::str('no placeholders here')),
            new HasTextValue('no placeholders here')
        );
    }

    #[Test]
    public function honoursPositionalSpecifiers(): void
    {
        self::assertThat(
            new FormattedText(TextOf::str('%2$s %1$s'), 'world', 'hello'),
            new HasTextValue('hello world')
        );
    }

    #[Test]
    public function preservesMultibyteCharactersInPatternAndArguments(): void
    {
        self::assertThat(
            new FormattedText(TextOf::str('café %s'), 'привет'),
            new HasTextValue('café привет')
        );
    }

    #[Test]
    public function ofStringFormatsNativeStringPattern(): void
    {
        self::assertThat(
            FormattedText::ofString('Hello, %s!', 'world'),
            new HasTextValue('Hello, world!')
        );
    }

    #[Test]
    #[DataProvider('inputs')]
    public function ofStringAgreesWithTextFormOnEveryInput(string $pattern, array $arguments): void
    {
        self::assertSame(
            (new FormattedText(TextOf::str($pattern), ...$arguments))->value(),
            FormattedText::ofString($pattern, ...$arguments)->value(),
        );
    }

    /**
     * @return array<string, array{string, list<int|float|string>}>
     */
    public static function inputs(): array
    {
        return [
            'string substitution' => ['Hello, %s!', ['world']],
            'int and float' => ['%d items at %.2f each', [5, 3.5]],
            'no placeholders' => ['no placeholders here', []],
            'positional' => ['%2$s %1$s', ['world', 'hello']],
            'multibyte' => ['café %s', ['привет']],
        ];
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $pattern = TextOf::str('Hello, %s! You have %d messages.');

        self::assertSame(
            (new FormattedText($pattern, 'world', 5))->value(),
            FormattedText::ofText($pattern, 'world', 5)->value(),
        );
    }
}
