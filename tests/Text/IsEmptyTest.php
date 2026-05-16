<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Text\IsEmpty;
use Primus\Text\TextOf;

final class IsEmptyTest extends TestCase
{
    #[Test]
    #[DataProvider('falsyStrings')]
    public function returnsTrueWhenTextIsFalsy(string $input): void
    {
        $this->assertTrue(
            (new IsEmpty(TextOf::ofString($input)))->value(),
            'Expected true for PHP-falsy string: "' . $input . '"'
        );
    }

    #[Test]
    #[DataProvider('truthyStrings')]
    public function returnsFalseWhenTextIsTruthy(string $input): void
    {
        $this->assertFalse(
            (new IsEmpty(TextOf::ofString($input)))->value(),
            'Expected false for PHP-truthy string: "' . \addcslashes($input, "\t\n\r") . '"'
        );
    }

    public static function falsyStrings(): array
    {
        return [
            'empty string' => [''],
            'zero string' => ['0'],
        ];
    }

    public static function truthyStrings(): array
    {
        return [
            'single space' => [' '],
            'newline' => ["\n"],
            'tab' => ["\t"],
            'letter' => ['a'],
            'word' => ['hello'],
            'zero with space' => [' 0'],
            'double zero' => ['00'],
        ];
    }
}
