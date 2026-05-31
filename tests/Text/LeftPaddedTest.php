<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\LeftPadded;
use Primus\Text\TextOf;

/**
 */
final class LeftPaddedTest extends TestCase
{
    #[Test]
    public function padsTextOnLeft(): void
    {
        self::assertThat(
            new LeftPadded(TextOf::str('foo'), 6, '.'),
            new HasTextValue('...foo')
        );
    }

    #[Test]
    public function returnsOriginalWhenLengthIsShorter(): void
    {
        self::assertThat(
            new LeftPadded(TextOf::str('foobar'), 3, '.'),
            new HasTextValue('foobar')
        );
    }

    #[Test]
    public function padsWithSpacesByDefault(): void
    {
        self::assertThat(
            new LeftPadded(TextOf::str('bar'), 6, ' '),
            new HasTextValue('   bar')
        );
    }

    #[Test]
    public function handlesEmptyText(): void
    {
        self::assertThat(
            new LeftPadded(TextOf::str(''), 6, '.'),
            new HasTextValue('......')
        );
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('foo');

        self::assertSame(
            (new LeftPadded($source, 6, '.'))->value(),
            LeftPadded::ofText($source, 6, '.')->value(),
        );
    }

    #[Test]
    public function ofStringFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new LeftPadded(TextOf::str('foo'), 6, '.'))->value(),
            LeftPadded::ofString('foo', 6, '.')->value(),
        );
    }
}
