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
            new RightPadded(TextOf::str('12'), 5, '0'),
            new HasTextValue('12000')
        );
    }

    #[Test]
    public function returnsTextPaddedWithSpacesToRight(): void
    {
        self::assertThat(
            new RightPadded(TextOf::str('abc'), 6, ' '),
            new HasTextValue('abc   ')
        );
    }

    #[Test]
    public function returnsSameTextWhenLengthExceedsPadding(): void
    {
        self::assertThat(
            new RightPadded(TextOf::str('foobar'), 4, '*'),
            new HasTextValue('foobar')
        );
    }

    #[Test]
    public function returnsPaddingOnlyWhenTextIsEmpty(): void
    {
        self::assertThat(
            new RightPadded(TextOf::str(''), 3, '.'),
            new HasTextValue('...')
        );
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('foo');

        self::assertSame(
            (new RightPadded($source, 6, '.'))->value(),
            RightPadded::ofText($source, 6, '.')->value(),
        );
    }

    #[Test]
    public function ofStringFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new RightPadded(TextOf::str('foo'), 6, '.'))->value(),
            RightPadded::ofString('foo', 6, '.')->value(),
        );
    }
}
