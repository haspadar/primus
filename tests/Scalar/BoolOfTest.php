<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

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
    public function parsesCanonicalTrueLiterals(string $input): void
    {
        self::assertTrue(
            (new BoolOf(TextOf::str($input)))->value(),
        );
    }

    #[Test]
    #[TestWith(['false'])]
    #[TestWith(['FALSE'])]
    #[TestWith(['no'])]
    #[TestWith(['NO'])]
    #[TestWith(['off'])]
    #[TestWith(['OFF'])]
    #[TestWith(['0'])]
    public function parsesCanonicalFalseLiterals(string $input): void
    {
        self::assertFalse(
            (new BoolOf(TextOf::str($input)))->value(),
        );
    }

    #[Test]
    public function returnsFalseForArbitraryNonBooleanText(): void
    {
        self::assertFalse(
            (new BoolOf(TextOf::str('garbage')))->value(),
        );
    }

    #[Test]
    public function returnsFalseForEmptyText(): void
    {
        self::assertFalse(
            (new BoolOf(TextOf::str('')))->value(),
        );
    }

    #[Test]
    public function toleratesSurroundingWhitespace(): void
    {
        self::assertTrue(
            (new BoolOf(TextOf::str(' true ')))->value(),
        );
    }

    #[Test]
    public function defersTextResolutionUntilValueCall(): void
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
        $flag = new BoolOf($text);

        self::assertFalse($resolved);
        self::assertTrue($flag->value());
        self::assertTrue($resolved);
    }
}
