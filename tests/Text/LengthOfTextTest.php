<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasSize;
use Primus\Text\TextOf;

/**
 */
final class LengthOfTextTest extends TestCase
{
    #[Test]
    public function returnsLengthFiveWhenTextIsAscii(): void
    {
        self::assertThat(
            TextOf::str('hello'),
            new HasSize(5)
        );
    }

    #[Test]
    public function returnsLengthFiveWhenTextContainsDiacritics(): void
    {
        self::assertThat(
            TextOf::str('àéîöü'),
            new HasSize(5)
        );
    }

    #[Test]
    public function returnsZeroWhenTextIsEmpty(): void
    {
        self::assertThat(
            TextOf::str(''),
            new HasSize(0)
        );
    }
}
