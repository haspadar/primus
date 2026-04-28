<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\PredicateOf;
use Primus\List\Filtered;
use Primus\List\ListOf;

final class FilteredTest extends TestCase
{
    #[Test]
    public function yieldsMatchingElements(): void
    {
        $this->assertSame(
            [40, 50],
            (new Filtered(
                new ListOf(10, 5, 40, 3, 50),
                new PredicateOf(static fn (int $x): bool => $x > 10),
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
                new PredicateOf(static fn (string $x): bool => strlen($x) > 5),
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
                new PredicateOf(static fn (int $x): bool => $x > 100),
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
                new PredicateOf(static fn (int $x): bool => $x % 2 === 0),
            ),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new ListOf(1, 2, 3, 4);
        $filtered = new Filtered(
            $source,
            new PredicateOf(static fn (int $x): bool => $x > 2),
        );
        $filtered->value();
        iterator_to_array($filtered);
        $this->assertSame([1, 2, 3, 4], $source->value());
    }
}
