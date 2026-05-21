<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Joined;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 */
final class JoinedTest extends TestCase
{
    #[Test]
    public function joinsTextsWithSeparator(): void
    {
        self::assertThat(
            new Joined(', ', [TextOf::str('a'), TextOf::str('b'), TextOf::str('c')]),
            new HasTextValue('a, b, c')
        );
    }

    #[Test]
    public function joinsWithoutSeparator(): void
    {
        self::assertThat(
            new Joined('', [TextOf::str('a'), TextOf::str('b'), TextOf::str('c')]),
            new HasTextValue('abc')
        );
    }

    #[Test]
    public function joinsSingleText(): void
    {
        self::assertThat(
            new Joined(', ', [TextOf::str('solo')]),
            new HasTextValue('solo')
        );
    }

    #[Test]
    public function joinsEmptyArray(): void
    {
        self::assertThat(
            new Joined(', ', []),
            new HasTextValue('')
        );
    }

    #[Test]
    public function defersValueResolutionUntilJoinedValueIsCalled(): void
    {
        $calls = 0;
        $part = new class ($calls) implements Text {
            public function __construct(private int &$calls) {}

            public function value(): string
            {
                $this->calls++;

                return 'x';
            }
        };
        new Joined(',', [$part, $part]); // NOSONAR — instantiation is the subject under test for the lazy contract

        self::assertSame(0, $calls);
    }

    #[Test]
    public function resolvesEachPartWhenJoinedValueIsCalled(): void
    {
        $calls = 0;
        $part = new class ($calls) implements Text {
            public function __construct(private int &$calls) {}

            public function value(): string
            {
                $this->calls++;

                return 'x';
            }
        };
        $joined = new Joined(',', [$part, $part]);
        $joined->value();

        self::assertSame(2, $calls);
    }

    #[Test]
    public function ofStringsJoinsNativeStringsWithSeparator(): void
    {
        self::assertThat(
            Joined::ofStrings(', ', 'a', 'b', 'c'),
            new HasTextValue('a, b, c')
        );
    }

    #[Test]
    public function ofStringsJoinsSingleNativeString(): void
    {
        self::assertThat(
            Joined::ofStrings(', ', 'solo'),
            new HasTextValue('solo')
        );
    }

    #[Test]
    public function ofStringsProducesEmptyResultWithoutParts(): void
    {
        self::assertThat(
            Joined::ofStrings(', '),
            new HasTextValue('')
        );
    }

    #[Test]
    #[DataProvider('joinedInputs')]
    public function ofStringsAgreesWithTextFormOnEveryInput(string $separator, array $parts): void
    {
        $texts = array_map(static fn(string $p): Text => TextOf::str($p), $parts);

        self::assertSame(
            (new Joined($separator, $texts))->value(),
            Joined::ofStrings($separator, ...$parts)->value(),
        );
    }

    /**
     * @return array<string, array{string, list<string>}>
     */
    public static function joinedInputs(): array
    {
        return [
            'empty parts' => [', ', []],
            'single part' => [', ', ['solo']],
            'multiple parts' => [', ', ['a', 'b', 'c']],
            'empty separator' => ['', ['a', 'b', 'c']],
            'multibyte parts' => [' & ', ['café', 'привет']],
            'multichar separator' => [' -- ', ['a', 'b']],
        ];
    }

}
