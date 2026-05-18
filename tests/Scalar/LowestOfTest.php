<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\List_;
use Primus\List\ListOf;
use Primus\Scalar\LowestOf;
use UnderflowException;

final class LowestOfTest extends TestCase
{
    #[Test]
    public function returnsSmallestIntegerInList(): void
    {
        self::assertSame(
            1,
            (new LowestOf(new ListOf(7, 1, 3, 5)))->value(),
        );
    }

    #[Test]
    public function returnsSmallestFloatInList(): void
    {
        self::assertSame(
            1.5,
            (new LowestOf(new ListOf(2.0, 1.5, 3.14)))->value(),
        );
    }

    #[Test]
    public function returnsLexicographicallySmallestString(): void
    {
        self::assertSame(
            'apple',
            (new LowestOf(new ListOf('orange', 'apple', 'banana')))->value(),
        );
    }

    #[Test]
    public function returnsSoleElementForSingleItemList(): void
    {
        self::assertSame(
            42,
            (new LowestOf(new ListOf(42)))->value(),
        );
    }

    #[Test]
    public function returnsValueWhenAllEqual(): void
    {
        self::assertSame(
            5,
            (new LowestOf(new ListOf(5, 5, 5)))->value(),
        );
    }

    #[Test]
    public function throwsWhenSourceIsEmpty(): void
    {
        $this->expectException(UnderflowException::class);
        (new LowestOf(new ListOf()))->value();
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

        $bottom = new LowestOf($source);

        self::assertSame(0, $touched);
        self::assertSame(1, $bottom->value());
        self::assertSame(3, $touched);
    }
}
