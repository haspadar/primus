<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\RightPadded;
use Primus\Text\TextOf;

/**
 */
final class RightPaddedTest extends TestCase
{
    #[Test]
    public function returnsTextPaddedWithZerosToRight(): void
    {
        self::assertThat(
            new RightPadded(TextOf::ofString('12'), 5, '0'),
            new HasTextValue('12000')
        );
    }

    #[Test]
    public function returnsTextPaddedWithSpacesToRight(): void
    {
        self::assertThat(
            new RightPadded(TextOf::ofString('abc'), 6, ' '),
            new HasTextValue('abc   ')
        );
    }

    #[Test]
    public function returnsSameTextWhenLengthExceedsPadding(): void
    {
        self::assertThat(
            new RightPadded(TextOf::ofString('foobar'), 4, '*'),
            new HasTextValue('foobar')
        );
    }

    #[Test]
    public function returnsPaddingOnlyWhenTextIsEmpty(): void
    {
        self::assertThat(
            new RightPadded(TextOf::ofString(''), 3, '.'),
            new HasTextValue('...')
        );
    }
}
