<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\ScalarOf;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\TextOfScalar;

/**
 */
final class TextOfScalarTest extends TestCase
{
    #[Test]
    public function returnsValueFromScalar(): void
    {
        self::assertThat(
            new TextOfScalar(new ScalarOf(fn (): string => 'hello')),
            new HasTextValue('hello')
        );
    }

    #[Test]
    public function ofScalarFactoryAgreesWithPrimaryConstructor(): void
    {
        $scalar = new ScalarOf(static fn(): string => 'hello');

        self::assertSame(
            (new TextOfScalar($scalar))->value(),
            TextOfScalar::ofScalar($scalar)->value(),
        );
    }
}
