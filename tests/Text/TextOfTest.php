<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\TextOf;

final class TextOfTest extends TestCase
{
    #[Test]
    public function strExposesPlainStringAsTextValue(): void
    {
        self::assertThat(
            TextOf::str('hello'),
            new HasTextValue('hello'),
        );
    }

    #[Test]
    public function strPreservesArbitraryStringContent(): void
    {
        self::assertThat(
            TextOf::str('world'),
            new HasTextValue('world'),
        );
    }

    #[Test]
    public function scalarDefersStringResolutionUntilValueCall(): void
    {
        $resolved = false;
        $text = TextOf::scalar(
            new ScalarOf(
                static function () use (&$resolved): string {
                    $resolved = true;

                    return 'lazy';
                },
            ),
        );

        self::assertFalse($resolved);
        self::assertThat($text, new HasTextValue('lazy'));
        self::assertTrue($resolved);
    }
}
