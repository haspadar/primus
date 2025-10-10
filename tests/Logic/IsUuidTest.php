<?php

declare(strict_types=1);

namespace Primus\Tests\Logic;

use Primus\Logic\IsUuid;
use Primus\Text\TextOf;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class IsUuidTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenTextIsValidUuid(): void
    {
        $this->assertTrue(
            new IsUuid(new TextOf('123e4567-E89B-12d3-a456-426614174000'))->value(),
            'Expected true for valid UUID "123e4567-E89B-12d3-a456-426614174000"'
        );
    }

    #[Test]
    #[DataProvider('nonUuidStrings')]
    public function returnsFalseWhenTextIsInvalidUuid(string $input): void
    {
        $this->assertFalse(
            new IsUuid(new TextOf($input))->value(),
            'Expected false for invalid UUID string: "' . \addcslashes($input, "\t\n\r") . '"'
        );
    }

    public static function nonUuidStrings(): array
    {
        return [
            'too short' => ['123'],
            'non-hex characters' => ['g3c1aa80-1234-5678-89ab-123456789012'],
            'missing dashes' => ['3c1aa801234567889ab123456789012'],
            'prefix added' => ['xx3c1aa80-1234-5678-89ab-123456789012'],
            'symbolic prefix' => ['!!!3c1aa80-1234-5678-89ab-123456789012'],
            'newline at end' => ["3c1aa80-1234-5678-89ab-123456789012\n"],
            'valid with prefix' => ['abc123e4567-e89b-12d3-a456-426614174000'],
            'valid with suffix' => ['123e4567-e89b-12d3-a456-426614174000xyz'],
        ];
    }
}
