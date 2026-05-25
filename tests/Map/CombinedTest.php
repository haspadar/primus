<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\Map\Combined;
use RuntimeException;

final class CombinedTest extends TestCase
{
    #[Test]
    public function buildsEmptyMapFromTwoEmptyLists(): void
    {
        $this->assertSame(
            [],
            (new Combined(new ListOf(), new ListOf()))->value(),
        );
    }

    #[Test]
    public function zipsKeysAndValuesByPosition(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2, 'c' => 3],
            (new Combined(
                new ListOf('a', 'b', 'c'),
                new ListOf(1, 2, 3),
            ))->value(),
        );
    }

    #[Test]
    public function preservesPositionOrderInResult(): void
    {
        $this->assertSame(
            ['z' => 'first', 'a' => 'second'],
            (new Combined(
                new ListOf('z', 'a'),
                new ListOf('first', 'second'),
            ))->value(),
        );
    }

    #[Test]
    public function supportsIntegerKeys(): void
    {
        $this->assertSame(
            [10 => 'ten', 20 => 'twenty'],
            (new Combined(
                new ListOf(10, 20),
                new ListOf('ten', 'twenty'),
            ))->value(),
        );
    }

    #[Test]
    public function distinguishesNumericStringKeyFromIntegerKey(): void
    {
        $this->assertSame(
            [1 => 'one', '01' => 'leadingZero'],
            (new Combined(
                new ListOf(1, '01'),
                new ListOf('one', 'leadingZero'),
            ))->value(),
        );
    }

    #[Test]
    public function laterDuplicateKeyOverwritesEarlier(): void
    {
        $this->assertSame(
            ['a' => 2],
            (new Combined(
                new ListOf('a', 'a'),
                new ListOf(1, 2),
            ))->value(),
        );
    }

    #[Test]
    public function failsWhenKeysListLongerThanValues(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Combined map sources differ in length: 3 keys vs 2 values');

        (new Combined(
            new ListOf('a', 'b', 'c'),
            new ListOf(1, 2),
        ))->value();
    }

    #[Test]
    public function failsWhenValuesListLongerThanKeys(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Combined map sources differ in length: 1 keys vs 4 values');

        (new Combined(
            new ListOf('only'),
            new ListOf(1, 2, 3, 4),
        ))->value();
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $combined = new Combined(
            new ListOf('a', 'b'),
            new ListOf(1, 2),
        );
        $this->assertSame(
            $combined->value(),
            iterator_to_array($combined),
        );
    }

    #[Test]
    public function countsZippedPairs(): void
    {
        $this->assertCount(
            3,
            new Combined(
                new ListOf('a', 'b', 'c'),
                new ListOf(1, 2, 3),
            ),
        );
    }

    #[Test]
    public function leavesSourcesUntouchedAfterReading(): void
    {
        $keys = new ListOf('a', 'b');
        $values = new ListOf(1, 2);
        $combined = new Combined($keys, $values);
        $combined->value();
        iterator_to_array($combined);
        $this->assertSame(['a', 'b'], $keys->value());
        $this->assertSame([1, 2], $values->value());
    }

    #[Test]
    public function ofListsFactoryAgreesWithPrimaryConstructor(): void
    {
        $keys = new ListOf('a', 'b', 'c');
        $values = new ListOf(1, 2, 3);

        self::assertSame(
            (new Combined($keys, $values))->value(),
            Combined::ofLists($keys, $values)->value(),
        );
    }
}
