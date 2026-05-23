<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiFuncOf;
use Primus\List\List_;
use Primus\List\ListOf;
use Primus\Scalar\Reduced;
use UnderflowException;

final class ReducedTest extends TestCase
{
    #[Test]
    public function sumsIntegersByLeftFold(): void
    {
        self::assertSame(
            10,
            (new Reduced(
                new ListOf(1, 2, 3, 4),
                new BiFuncOf(static fn(int $a, int $b): int => $a + $b),
            ))->value(),
        );
    }

    #[Test]
    public function concatenatesStringsByLeftFold(): void
    {
        self::assertSame(
            'abc',
            (new Reduced(
                new ListOf('a', 'b', 'c'),
                new BiFuncOf(static fn(string $a, string $b): string => $a . $b),
            ))->value(),
        );
    }

    #[Test]
    public function returnsSoleElementForSingleItemList(): void
    {
        self::assertSame(
            42,
            (new Reduced(
                new ListOf(42),
                new BiFuncOf(static fn(int $a, int $b): int => $a + $b),
            ))->value(),
        );
    }

    #[Test]
    public function throwsWhenSourceIsEmpty(): void
    {
        $this->expectException(UnderflowException::class);
        (new Reduced(
            new ListOf(),
            new BiFuncOf(static fn(mixed $a, mixed $b): mixed => $a),
        ))->value();
    }

    #[Test]
    public function appliesAccumulatorLeftToRight(): void
    {
        // (((1-2)-3)-4) = -8, would be -2 if right-to-left
        self::assertSame(
            -8,
            (new Reduced(
                new ListOf(1, 2, 3, 4),
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

        $sum = new Reduced(
            $source,
            new BiFuncOf(static fn(int $a, int $b): int => $a + $b),
        );

        self::assertSame(0, $touched);
        self::assertSame(6, $sum->value());
        self::assertSame(3, $touched);
    }

    #[Test]
    public function ofListFactoryAgreesWithPrimaryConstructor(): void
    {
        $list = new ListOf(1, 2, 3, 4);
        $reducer = new BiFuncOf(static fn(int $a, int $b): int => $a + $b);

        self::assertSame(
            (new Reduced($list, $reducer))->value(),
            Reduced::ofList($list, $reducer)->value(),
        );
    }
}
