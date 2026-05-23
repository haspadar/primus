<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use OutOfBoundsException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\IndexOf;
use Primus\List\ListOf;

final class IndexOfTest extends TestCase
{
    #[Test]
    public function returnsZeroBasedIndexOfStrictMatch(): void
    {
        $this->assertSame(
            1,
            (new IndexOf(new ListOf('a', 'b', 'c'), 'b'))->value(),
        );
    }

    #[Test]
    public function returnsFirstOccurrenceWhenValueRepeats(): void
    {
        $this->assertSame(
            1,
            (new IndexOf(new ListOf('x', 'y', 'y', 'y'), 'y'))->value(),
        );
    }

    #[Test]
    public function distinguishesValuesByStrictType(): void
    {
        $this->expectException(OutOfBoundsException::class);

        (new IndexOf(new ListOf('0', false, null), 0))->value();
    }

    #[Test]
    public function rejectsValueAccessForAbsentValue(): void
    {
        $this->expectException(OutOfBoundsException::class);

        (new IndexOf(new ListOf(1, 2, 3), 99))->value();
    }

    #[Test]
    public function rejectsValueAccessForEmptyList(): void
    {
        $this->expectException(OutOfBoundsException::class);

        (new IndexOf(new ListOf(), 'anything'))->value();
    }

    #[Test]
    public function findsValueAtPositionZero(): void
    {
        $this->assertSame(
            0,
            (new IndexOf(new ListOf('start', 'middle', 'end'), 'start'))->value(),
        );
    }

    #[Test]
    public function listFactoryAgreesWithPrimaryConstructor(): void
    {
        $list = new ListOf('start', 'middle', 'end');

        self::assertSame(
            (new IndexOf($list, 'middle'))->value(),
            IndexOf::list($list, 'middle')->value(),
        );
    }
}
