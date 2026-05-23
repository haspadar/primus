<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\List\ListOf;
use Primus\Scalar\Constant;
use Primus\Scalar\FirstOf;

final class FirstOfTest extends TestCase
{
    #[Test]
    public function returnsFirstMatchingElement(): void
    {
        self::assertSame(
            7,
            (new FirstOf(
                new FuncOf(static fn(int $n): bool => $n > 5),
                new ListOf(1, 3, 7, 10),
                new Constant(0),
            ))->value(),
        );
    }

    #[Test]
    public function returnsFirstWhenMultipleMatch(): void
    {
        self::assertSame(
            7,
            (new FirstOf(
                new FuncOf(static fn(int $n): bool => $n > 5),
                new ListOf(7, 10, 20),
                new Constant(0),
            ))->value(),
        );
    }

    #[Test]
    public function returnsFallbackWhenNoElementMatches(): void
    {
        self::assertSame(
            -1,
            (new FirstOf(
                new FuncOf(static fn(int $n): bool => $n > 100),
                new ListOf(1, 3, 7, 10),
                new Constant(-1),
            ))->value(),
        );
    }

    #[Test]
    public function returnsFallbackForEmptySource(): void
    {
        self::assertSame(
            'none',
            (new FirstOf(
                new FuncOf(static fn(string $s): bool => true),
                new ListOf(),
                new Constant('none'),
            ))->value(),
        );
    }

    #[Test]
    public function defersSourceTraversalUntilValueCall(): void
    {
        $touched = false;
        $source = new ListOf(1, 2, 3);
        $first = new FirstOf(
            new FuncOf(
                static function (int $n) use (&$touched): bool {
                    $touched = true;

                    return $n > 1;
                },
            ),
            $source,
            new Constant(0),
        );

        self::assertFalse($touched);
        self::assertSame(2, $first->value());
        self::assertTrue($touched);
    }

    #[Test]
    public function stopsAtFirstMatchWithoutScanningRemaining(): void
    {
        $visited = 0;
        $first = new FirstOf(
            new FuncOf(
                static function (int $n) use (&$visited): bool {
                    $visited++;

                    return $n === 2;
                },
            ),
            new ListOf(1, 2, 3, 4, 5),
            new Constant(0),
        );

        self::assertSame(2, $first->value());
        self::assertSame(2, $visited);
    }

    #[Test]
    public function listFactoryAgreesWithPrimaryConstructor(): void
    {
        $predicate = new FuncOf(static fn(int $n): bool => $n > 5);
        $list = new ListOf(1, 3, 7, 10);
        $fallback = new Constant(0);

        self::assertSame(
            (new FirstOf($predicate, $list, $fallback))->value(),
            FirstOf::list($predicate, $list, $fallback)->value(),
        );
    }
}
