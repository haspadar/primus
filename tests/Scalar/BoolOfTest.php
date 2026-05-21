<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\BoolOf;
use Primus\Scalar\ScalarOf;
use Primus\Text\TextOf;

final class BoolOfTest extends TestCase
{
    #[Test]
    #[TestWith(['true'])]
    #[TestWith(['TRUE'])]
    #[TestWith(['yes'])]
    #[TestWith(['YES'])]
    #[TestWith(['on'])]
    #[TestWith(['ON'])]
    #[TestWith(['1'])]
    public function strParsesCanonicalTrueLiterals(string $input): void
    {
        self::assertTrue(BoolOf::str($input)->value());
    }

    #[Test]
    #[TestWith(['false'])]
    #[TestWith(['FALSE'])]
    #[TestWith(['no'])]
    #[TestWith(['NO'])]
    #[TestWith(['off'])]
    #[TestWith(['OFF'])]
    #[TestWith(['0'])]
    public function strParsesCanonicalFalseLiterals(string $input): void
    {
        self::assertFalse(BoolOf::str($input)->value());
    }

    #[Test]
    public function strReturnsFalseForArbitraryNonBooleanInput(): void
    {
        self::assertFalse(BoolOf::str('garbage')->value());
    }

    #[Test]
    public function strReturnsFalseForEmptyInput(): void
    {
        self::assertFalse(BoolOf::str('')->value());
    }

    #[Test]
    public function strToleratesSurroundingWhitespace(): void
    {
        self::assertTrue(BoolOf::str(' true ')->value());
    }

    #[Test]
    #[DataProvider('parsingInputs')]
    public function textFormAgreesWithStringFormOnEveryInput(string $input): void
    {
        self::assertSame(
            BoolOf::str($input)->value(),
            BoolOf::text(TextOf::str($input))->value(),
        );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function parsingInputs(): array
    {
        return [
            'true literal' => ['true'],
            'TRUE literal' => ['TRUE'],
            'false literal' => ['false'],
            'FALSE literal' => ['FALSE'],
            'yes' => ['yes'],
            'YES' => ['YES'],
            'no' => ['no'],
            'NO' => ['NO'],
            'on' => ['on'],
            'ON' => ['ON'],
            'off' => ['off'],
            'OFF' => ['OFF'],
            'one' => ['1'],
            'zero' => ['0'],
            'arbitrary garbage' => ['garbage'],
            'empty string' => [''],
            'whitespace padded true' => [' true '],
            'whitespace padded garbage' => ['  garbage  '],
        ];
    }

    #[Test]
    public function textFormDefersResolutionUntilValueCall(): void
    {
        $resolved = false;
        $text = TextOf::scalar(
            new ScalarOf(
                static function () use (&$resolved): string {
                    $resolved = true;

                    return 'true';
                },
            ),
        );
        $flag = BoolOf::text($text);

        self::assertFalse($resolved);
        self::assertTrue($flag->value());
        self::assertTrue($resolved);
    }
}
