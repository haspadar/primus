<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Mapped;
use Primus\Text\TextOf;

/**
 */
final class MappedTest extends TestCase
{
    #[Test]
    public function appliesFunctionToOriginValue(): void
    {
        self::assertThat(
            new Mapped(TextOf::str('hello'), new FuncOf(strtoupper(...))),
            new HasTextValue('HELLO'),
        );
    }

    #[Test]
    public function defersFunctionUntilValueIsCalled(): void
    {
        $calls = 0;
        new Mapped( // NOSONAR — instantiation is the subject under test for the lazy contract
            TextOf::str('x'),
            new FuncOf(static function (string $s) use (&$calls): string {
                $calls++;

                return $s;
            }),
        );

        self::assertSame(0, $calls);
    }

    #[Test]
    public function appliesFunctionWhenValueIsCalled(): void
    {
        $calls = 0;
        $mapped = new Mapped(
            TextOf::str('x'),
            new FuncOf(static function (string $s) use (&$calls): string {
                $calls++;

                return $s;
            }),
        );
        $mapped->value();

        self::assertSame(1, $calls);
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('hello');
        $mapper = new FuncOf(strtoupper(...));

        self::assertSame(
            (new Mapped($source, $mapper))->value(),
            Mapped::ofText($source, $mapper)->value(),
        );
    }
}
