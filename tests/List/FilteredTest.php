<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\List\Filtered;
use Primus\List\ListOf;
use Primus\List\Reversed;

final class FilteredTest extends TestCase
{
    #[Test]
    public function yieldsMatchingElements(): void
    {
        $this->assertSame(
            [40, 50],
            (new Filtered(
                new ListOf(10, 5, 40, 3, 50),
                new FuncOf(static fn (int $x): bool => $x > 10),
            ))->value(),
        );
    }

    #[Test]
    public function preservesRelativeOrder(): void
    {
        $this->assertSame(
            ['banana', 'cherry'],
            (new Filtered(
                new ListOf('apple', 'banana', 'cherry'),
                new FuncOf(static fn (string $x): bool => strlen($x) > 5),
            ))->value(),
        );
    }

    #[Test]
    public function yieldsNothingWhenNoneMatch(): void
    {
        $this->assertCount(
            0,
            new Filtered(
                new ListOf(1, 2, 3),
                new FuncOf(static fn (int $x): bool => $x > 100),
            ),
        );
    }

    #[Test]
    public function countReflectsMatchedElements(): void
    {
        $this->assertCount(
            2,
            new Filtered(
                new ListOf(1, 2, 3, 4),
                new FuncOf(static fn (int $x): bool => $x % 2 === 0),
            ),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new ListOf(1, 2, 3, 4);
        $filtered = new Filtered(
            $source,
            new FuncOf(static fn (int $x): bool => $x > 2),
        );
        $filtered->value();
        iterator_to_array($filtered);
        $this->assertSame([1, 2, 3, 4], $source->value());
    }

    #[Test]
    public function composesWithReversed(): void
    {
        $this->assertSame(
            [4, 3],
            (new Reversed(
                new Filtered(
                    new ListOf(1, 2, 3, 4),
                    new FuncOf(static fn (int $x): bool => $x > 2),
                ),
            ))->value(),
        );
    }
}
