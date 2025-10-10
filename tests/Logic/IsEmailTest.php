<?php

declare(strict_types=1);

namespace Primus\Tests\Logic;

use Primus\Logic\IsEmail;
use Primus\Text\TextOf;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class IsEmailTest extends TestCase
{
    #[Test]
    #[DataProvider('validEmailStrings')]
    public function returnsTrueWhenTextIsValidEmail(string $email): void
    {
        $this->assertTrue(
            new IsEmail(new TextOf($email))->value(),
            'Expected true for valid email: "' . $email . '"'
        );
    }

    #[Test]
    #[DataProvider('invalidEmailStrings')]
    public function returnsFalseWhenTextIsInvalidEmail(string $email): void
    {
        $this->assertFalse(
            new IsEmail(new TextOf($email))->value(),
            'Expected false for invalid email: "' . $email . '"'
        );
    }

    public static function validEmailStrings(): array
    {
        return [
            'simple' => ['user@example.com'],
            'with subdomain' => ['name.surname@sub.domain.org'],
            'numeric' => ['user123@domain.net'],
            'with plus' => ['user+tag@example.com'],
            'multiple dots' => ['user@sub.domain.example.com'],
            'hyphenated domain' => ['user@my-domain.com'],
        ];
    }

    public static function invalidEmailStrings(): array
    {
        return [
            'missing at' => ['userexample.com'],
            'missing domain' => ['user@'],
            'missing user' => ['@example.com'],
            'invalid character' => ['user@exa mple.com'],
        ];
    }
}
