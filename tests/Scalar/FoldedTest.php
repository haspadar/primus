<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiFuncOf;
use Primus\List\List_;
use Primus\List\ListOf;
use Primus\Scalar\Constant;
use Primus\Scalar\Folded;

final class FoldedTest extends TestCase
{
    #[Test]
    public function sumsIntegersStartingFromSeed(): void
    {
        self::assertSame(
            16,
            (new Folded(
                new Constant(10),
                new ListOf(1, 2, 3),
                new BiFuncOf(static fn(int $a, int $b): int => $a + $b),
            ))->value(),
        );
    }

    #[Test]
    public function returnsSeedForEmptySource(): void
    {
        self::assertSame(
            42,
            (new Folded(
                new Constant(42),
                new ListOf(),
                new BiFuncOf(static fn(int $a, int $b): int => $a + $b),
            ))->value(),
        );
    }

    #[Test]
    public function foldsHeterogeneousAccumulatorIntoIntFromStrings(): void
    {
        self::assertSame(
            10,
            (new Folded(
                new Constant(0),
                new ListOf('hello', 'world'),
                new BiFuncOf(static fn(int $sum, string $s): int => $sum + strlen($s)),
            ))->value(),
        );
    }

    #[Test]
    public function foldsHeterogeneousAccumulatorIntoStringFromInts(): void
    {
        self::assertSame(
            'init:1:2:3',
            (new Folded(
                new Constant('init'),
                new ListOf(1, 2, 3),
                new BiFuncOf(static fn(string $acc, int $n): string => $acc . ':' . $n),
            ))->value(),
        );
    }

    #[Test]
    public function appliesReducerLeftToRight(): void
    {
        // (((10 - 1) - 2) - 3) = 4, would be 10 if right-to-left
        self::assertSame(
            4,
            (new Folded(
                new Constant(10),
                new ListOf(1, 2, 3),
                new BiFuncOf(static fn(int $a, int $b): int => $a - $b),
            ))->value(),
        );
    }

    #[Test]
    public function defersTraversalUntilValueCall(): void
    {
        $touched = 0;
        $source = new class ($touched) implements List_ {
            public function __construct(private int &$touched) {}

            public function value(): array
            {
                return iterator_to_array($this->getIterator(), false);
            }

            public function count(): int
            {
                return 3;
            }

            public function getIterator(): Generator
            {
                for ($i = 1; $i <= 3; $i++) {
                    $this->touched++;
                    yield $i;
                }
            }
        };

        $folded = new Folded(
            new Constant(0),
            $source,
            new BiFuncOf(static fn(int $a, int $b): int => $a + $b),
        );

        self::assertSame(0, $touched);
        self::assertSame(6, $folded->value());
        self::assertSame(3, $touched);
    }
}
