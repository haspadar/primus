<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

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
            new FormattedText(TextOf::ofString('Hello, %s!'), 'world'),
            new HasTextValue('Hello, world!')
        );
    }

    #[Test]
    public function substitutesIntAndFloatArguments(): void
    {
        self::assertThat(
            new FormattedText(TextOf::ofString('%d items at %.2f each'), 5, 3.5),
            new HasTextValue('5 items at 3.50 each')
        );
    }

    #[Test]
    public function returnsPatternUnchangedWhenNoPlaceholders(): void
    {
        self::assertThat(
            new FormattedText(TextOf::ofString('no placeholders here')),
            new HasTextValue('no placeholders here')
        );
    }

    #[Test]
    public function honoursPositionalSpecifiers(): void
    {
        self::assertThat(
            new FormattedText(TextOf::ofString('%2$s %1$s'), 'world', 'hello'),
            new HasTextValue('hello world')
        );
    }

    #[Test]
    public function preservesMultibyteCharactersInPatternAndArguments(): void
    {
        self::assertThat(
            new FormattedText(TextOf::ofString('café %s'), 'привет'),
            new HasTextValue('café привет')
        );
    }
}
