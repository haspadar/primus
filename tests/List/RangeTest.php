<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\Range;
use ValueError;

final class RangeTest extends TestCase
{
    #[Test]
    public function startEqualToEndProducesSingleElementList(): void
    {
        $this->assertSame(
            [5],
            (new Range(5, 5))->value(),
        );
    }

    #[Test]
    public function ascendingSequenceWalksFromStartToEndByStep(): void
    {
        $this->assertSame(
            [1, 3, 5, 7],
            (new Range(1, 7, 2))->value(),
        );
    }

    #[Test]
    public function descendingSequenceWalksFromStartToEndByStep(): void
    {
        $this->assertSame(
            [7, 5, 3, 1],
            (new Range(7, 1, 2))->value(),
        );
    }

    #[Test]
    public function firstElementIsTheStart(): void
    {
        $this->assertSame(
            10,
            (new Range(10, 30, 3))->value()[0],
        );
    }

    #[Test]
    public function stopsBeforeOvershootingEnd(): void
    {
        $this->assertSame(
            [1, 4, 7],
            (new Range(1, 8, 3))->value(),
        );
    }

    #[Test]
    public function defaultStepIsOne(): void
    {
        $this->assertSame(
            [1, 2, 3, 4, 5],
            (new Range(1, 5))->value(),
        );
    }

    #[Test]
    public function zeroStepRejectsValueAccess(): void
    {
        $this->expectException(ValueError::class);

        (new Range(1, 5, 0))->value();
    }

    #[Test]
    public function negativeStepRejectsValueAccess(): void
    {
        $this->expectException(ValueError::class);

        (new Range(1, 5, -2))->value();
    }

    #[Test]
    public function iteratesYieldingTheSequence(): void
    {
        $collected = [];
        foreach (new Range(1, 4) as $value) {
            $collected[] = $value;
        }
        $this->assertSame([1, 2, 3, 4], $collected);
    }

    #[Test]
    public function countMatchesSequenceLength(): void
    {
        $this->assertCount(4, new Range(1, 7, 2));
    }

    #[Test]
    public function ofBoundsFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new Range(1, 7, 2))->value(),
            Range::ofBounds(1, 7, 2)->value(),
        );
    }

    #[Test]
    public function ofBoundsFactoryAgreesWithPrimaryConstructorForDefaultStep(): void
    {
        self::assertSame(
            (new Range(1, 5))->value(),
            Range::ofBounds(1, 5)->value(),
        );
    }

    #[Test]
    public function ofBoundsFactoryAgreesWithPrimaryConstructorForDescending(): void
    {
        self::assertSame(
            (new Range(5, 1))->value(),
            Range::ofBounds(5, 1)->value(),
        );
    }
}
