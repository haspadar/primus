<?php

declare(strict_types=1);

namespace Primus\Tests\Logic;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Logic\IsAlphanumeric;
use Primus\Text\TextOf;

final class IsAlphanumericTest extends TestCase
{
    #[Test]
    #[DataProvider('alphanumericStrings')]
    public function returnsTrueWhenTextIsAlphanumeric(string $input): void
    {
        $this->assertTrue(
            (new IsAlphanumeric(new TextOf($input)))->value(),
            'Expected true for alphanumeric string "' . $input . '"'
        );
    }

    #[Test]
    #[DataProvider('nonAlphanumericStrings')]
    public function returnsFalseWhenTextIsNotAlphanumeric(string $input): void
    {
        $this->assertFalse(
            (new IsAlphanumeric(new TextOf($input)))->value(),
            'Expected false for non-alphanumeric string: "' . $input . '"'
        );
    }

    public static function nonAlphanumericStrings(): array
    {
        return [
            'contains symbols' => ['abc-123!'],
            'leading whitespace' => [' abc123'],
            'trailing whitespace' => ['abc123 '],
            'contains newline' => ["abc123\n"],
            'contains tab' => ["\tabc123"],
            'contains punctuation' => ['abc.123'],
        ];
    }

    public static function alphanumericStrings(): array
    {
        return [
            'mixed' => ['abc123XYZ'],
            'letters only' => ['abcXYZ'],
            'numbers only' => ['12345'],
            'single letter' => ['a'],
            'single number' => ['1'],
        ];
    }
}
