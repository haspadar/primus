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
    public function ofStringExposesPlainStringAsTextValue(): void
    {
        self::assertThat(
            TextOf::ofString('hello'),
            new HasTextValue('hello'),
        );
    }

    #[Test]
    public function ofStringPreservesArbitraryStringContent(): void
    {
        self::assertThat(
            TextOf::ofString('world'),
            new HasTextValue('world'),
        );
    }

    #[Test]
    public function ofScalarDefersStringResolutionUntilValueCall(): void
    {
        $resolved = false;
        $text = TextOf::ofScalar(
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
