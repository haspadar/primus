<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\List\Reversed;

final class ReversedTest extends TestCase
{
    #[Test]
    public function reversesElementOrder(): void
    {
        $this->assertSame(
            [3, 2, 1],
            (new Reversed(new ListOf(1, 2, 3)))->value(),
        );
    }

    #[Test]
    public function preservesCount(): void
    {
        $this->assertCount(
            4,
            new Reversed(new ListOf('a', 'b', 'c', 'd')),
        );
    }

    #[Test]
    public function leavesSourceUntouched(): void
    {
        $source = new ListOf(1, 2, 3);
        new Reversed($source);
        $this->assertSame([1, 2, 3], $source->value());
    }

    #[Test]
    public function composesWithItself(): void
    {
        $this->assertSame(
            [1, 2, 3],
            (new Reversed(new Reversed(new ListOf(1, 2, 3))))->value(),
        );
    }
}
