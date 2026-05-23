<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;
use Primus\List\ListOf;
use Primus\List\Mapped;
use Primus\List\Reversed;

final class MappedTest extends TestCase
{
    #[Test]
    public function transformsEachElement(): void
    {
        $this->assertSame(
            [10, 20, 30],
            (new Mapped(
                new ListOf(1, 2, 3),
                new FuncOf(static fn (int $x): int => $x * 10),
            ))->value(),
        );
    }

    #[Test]
    public function preservesCount(): void
    {
        $this->assertCount(
            4,
            new Mapped(
                new ListOf('a', 'b', 'c', 'd'),
                new FuncOf(static fn (string $x): string => strtoupper($x)),
            ),
        );
    }

    #[Test]
    public function iteratesOverTransformedValues(): void
    {
        $collected = [];
        foreach (
            new Mapped(
                new ListOf(1, 2, 3),
                new FuncOf(static fn (int $x): int => $x + 100),
            ) as $value
        ) {
            $collected[] = $value;
        }
        $this->assertSame([101, 102, 103], $collected);
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new ListOf(1, 2, 3);
        $mapped = new Mapped(
            $source,
            new FuncOf(static fn (int $x): int => $x * 2),
        );
        $mapped->value();
        iterator_to_array($mapped);
        $this->assertSame([1, 2, 3], $source->value());
    }

    #[Test]
    public function composesWithReversed(): void
    {
        $this->assertSame(
            [30, 20, 10],
            (new Reversed(
                new Mapped(
                    new ListOf(1, 2, 3),
                    new FuncOf(static fn (int $x): int => $x * 10),
                ),
            ))->value(),
        );
    }

    #[Test]
    public function ofListFactoryAgreesWithPrimaryConstructor(): void
    {
        $list = new ListOf(1, 2, 3);
        $mapper = new FuncOf(static fn(int $x): int => $x * 10);

        self::assertSame(
            (new Mapped($list, $mapper))->value(),
            Mapped::ofList($list, $mapper)->value(),
        );
    }
}
