<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Repeated;
use Primus\Text\TextOf;

final class RepeatedTest extends TestCase
{
    #[Test]
    public function repeatsTextMultipleTimes(): void
    {
        self::assertThat(
            new Repeated(TextOf::str('xo'), 3),
            new HasTextValue('xoxoxo')
        );
    }

    #[Test]
    public function returnsEmptyWhenCountIsZero(): void
    {
        self::assertThat(
            new Repeated(TextOf::str('abc'), 0),
            new HasTextValue('')
        );
    }

    #[Test]
    public function returnsEmptyWhenCountIsNegative(): void
    {
        self::assertThat(
            new Repeated(TextOf::str('abc'), -2),
            new HasTextValue('')
        );
    }

    #[Test]
    public function repeatsEmptyText(): void
    {
        self::assertThat(
            new Repeated(TextOf::str(''), 5),
            new HasTextValue('')
        );
    }

    #[Test]
    public function repeatsSingleCharacter(): void
    {
        self::assertThat(
            new Repeated(TextOf::str('a'), 5),
            new HasTextValue('aaaaa')
        );
    }

    #[Test]
    public function repeatsUnicodeText(): void
    {
        self::assertThat(
            new Repeated(TextOf::str('🔥'), 3),
            new HasTextValue('🔥🔥🔥')
        );
    }

    #[Test]
    public function ofStringRepeatsNativeString(): void
    {
        self::assertThat(
            Repeated::ofString('xo', 3),
            new HasTextValue('xoxoxo')
        );
    }

    #[Test]
    #[DataProvider('inputs')]
    public function ofStringAgreesWithTextFormOnEveryInput(string $value, int $count): void
    {
        self::assertSame(
            (new Repeated(TextOf::str($value), $count))->value(),
            Repeated::ofString($value, $count)->value(),
        );
    }

    /**
     * @return array<string, array{string, int}>
     */
    public static function inputs(): array
    {
        return [
            'multiple repeats' => ['xo', 3],
            'zero count' => ['abc', 0],
            'negative count' => ['abc', -2],
            'empty input' => ['', 5],
            'single char' => ['a', 5],
            'unicode' => ['🔥', 3],
        ];
    }
}
