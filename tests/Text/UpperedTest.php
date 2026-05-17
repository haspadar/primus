<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\TextOf;
use Primus\Text\Uppered;

/**
 */
final class UpperedTest extends TestCase
{
    #[Test]
    public function returnsUppercaseWhenTextIsLowercase(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('hello')),
            new HasTextValue('HELLO')
        );
    }

    #[Test]
    public function returnsUppercaseWhenTextIsMixedCase(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('HeLLo WoRLD')),
            new HasTextValue('HELLO WORLD')
        );
    }

    #[Test]
    public function returnsUppercaseWhenTextContainsDiacritics(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('àéîöü')),
            new HasTextValue('ÀÉÎÖÜ')
        );
    }

    #[Test]
    public function returnsEmptyStringWhenInputIsEmpty(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('')),
            new HasTextValue('')
        );
    }

    #[Test]
    public function returnsSameTextWhenAlreadyUppercase(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('ALREADY')),
            new HasTextValue('ALREADY')
        );
    }

    #[Test]
    public function leavesSpecialCharactersUnchanged(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('test@123!')),
            new HasTextValue('TEST@123!')
        );
    }

    #[Test]
    public function returnsSameWhenTextContainsOnlyWhitespace(): void
    {
        self::assertThat(
            new Uppered(TextOf::str('   ')),
            new HasTextValue('   ')
        );
    }
}
