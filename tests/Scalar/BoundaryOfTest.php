<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Primus\List\List_;
use Primus\List\ListOf;
use Primus\Scalar\HighestOf;
use Primus\Scalar\LowestOf;
use UnderflowException;

/**
 * Joint test suite for the symmetric pair `HighestOf` / `LowestOf`.
 *
 * `#[TestWith]` parameterises each behavioural case over both classes so
 * the suite holds one shared specification of the boundary contract
 * instead of two near-identical mirror files.
 */
final class BoundaryOfTest extends TestCase
{
    #[Test]
    #[TestWith([HighestOf::class, [1, 7, 3, 5], 7])]
    #[TestWith([LowestOf::class, [7, 1, 3, 5], 1])]
    public function returnsBoundaryIntegerInList(string $class, array $items, int $expected): void
    {
        self::assertSame(
            $expected,
            (new $class(new ListOf(...$items)))->value(),
        );
    }

    #[Test]
    #[TestWith([HighestOf::class, [1.5, 3.14, 2.0], 3.14])]
    #[TestWith([LowestOf::class, [2.0, 1.5, 3.14], 1.5])]
    public function returnsBoundaryFloatInList(string $class, array $items, float $expected): void
    {
        self::assertSame(
            $expected,
            (new $class(new ListOf(...$items)))->value(),
        );
    }

    #[Test]
    #[TestWith([HighestOf::class, ['apple', 'orange', 'banana'], 'orange'])]
    #[TestWith([LowestOf::class, ['orange', 'apple', 'banana'], 'apple'])]
    public function returnsLexicographicallyBoundaryString(string $class, array $items, string $expected): void
    {
        self::assertSame(
            $expected,
            (new $class(new ListOf(...$items)))->value(),
        );
    }

    #[Test]
    #[TestWith([HighestOf::class])]
    #[TestWith([LowestOf::class])]
    public function returnsSoleElementForSingleItemList(string $class): void
    {
        self::assertSame(
            42,
            (new $class(new ListOf(42)))->value(),
        );
    }

    #[Test]
    #[TestWith([HighestOf::class])]
    #[TestWith([LowestOf::class])]
    public function returnsValueWhenAllEqual(string $class): void
    {
        self::assertSame(
            5,
            (new $class(new ListOf(5, 5, 5)))->value(),
        );
    }

    #[Test]
    #[TestWith([HighestOf::class])]
    #[TestWith([LowestOf::class])]
    public function throwsWhenSourceIsEmpty(string $class): void
    {
        $this->expectException(UnderflowException::class);
        (new $class(new ListOf()))->value();
    }

    #[Test]
    #[TestWith([HighestOf::class, 3])]
    #[TestWith([LowestOf::class, 1])]
    public function defersTraversalUntilValueCall(string $class, int $expected): void
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

        $boundary = new $class($source);

        self::assertSame(0, $touched);
        self::assertSame($expected, $boundary->value());
        self::assertSame(3, $touched);
    }
}
