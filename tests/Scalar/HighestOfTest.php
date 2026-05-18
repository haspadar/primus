<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use Generator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\List_;
use Primus\List\ListOf;
use Primus\Scalar\HighestOf;
use UnderflowException;

final class HighestOfTest extends TestCase
{
    #[Test]
    public function returnsLargestIntegerInList(): void
    {
        self::assertSame(
            7,
            (new HighestOf(new ListOf(1, 7, 3, 5)))->value(),
        );
    }

    #[Test]
    public function returnsLargestFloatInList(): void
    {
        self::assertSame(
            3.14,
            (new HighestOf(new ListOf(1.5, 3.14, 2.0)))->value(),
        );
    }

    #[Test]
    public function returnsLexicographicallyLargestString(): void
    {
        self::assertSame(
            'orange',
            (new HighestOf(new ListOf('apple', 'orange', 'banana')))->value(),
        );
    }

    #[Test]
    public function returnsSoleElementForSingleItemList(): void
    {
        self::assertSame(
            42,
            (new HighestOf(new ListOf(42)))->value(),
        );
    }

    #[Test]
    public function returnsValueWhenAllEqual(): void
    {
        self::assertSame(
            5,
            (new HighestOf(new ListOf(5, 5, 5)))->value(),
        );
    }

    #[Test]
    public function throwsWhenSourceIsEmpty(): void
    {
        $this->expectException(UnderflowException::class);
        (new HighestOf(new ListOf()))->value();
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

        $top = new HighestOf($source);

        self::assertSame(0, $touched);
        self::assertSame(3, $top->value());
        self::assertSame(3, $touched);
    }
}
