<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Lowered;
use Primus\Text\TextOf;

/**
 */
final class LoweredTest extends TestCase
{
    #[Test]
    public function returnsLowercaseWhenTextIsUppercase(): void
    {
        self::assertThat(
            new Lowered(TextOf::ofString('HELLO')),
            new HasTextValue('hello')
        );
    }

    #[Test]
    public function returnsLowercaseWhenTextIsMixedCase(): void
    {
        self::assertThat(
            new Lowered(TextOf::ofString('HeLLo WoRLD')),
            new HasTextValue('hello world')
        );
    }

    #[Test]
    public function returnsLowercaseWhenTextContainsDiacritics(): void
    {
        self::assertThat(
            new Lowered(TextOf::ofString('ÀÉÎÖÜ')),
            new HasTextValue('àéîöü')
        );
    }
}
