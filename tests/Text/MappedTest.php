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
 * @since 0.3
 */
final class MappedTest extends TestCase
{
    #[Test]
    public function appliesFunctionToOriginValue(): void
    {
        self::assertThat(
            new Mapped(new TextOf('hello'), new FuncOf(strtoupper(...))),
            new HasTextValue('HELLO'),
        );
    }

    #[Test]
    public function defersFunctionUntilValueIsCalled(): void
    {
        $calls = 0;
        new Mapped(
            new TextOf('x'),
            new FuncOf(static function (string $s) use (&$calls): string {
                $calls++;

                return $s;
            }),
        );

        self::assertSame(0, $calls);
    }
}
