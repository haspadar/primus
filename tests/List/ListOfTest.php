<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;

final class ListOfTest extends TestCase
{
    #[Test]
    public function exposesValuesAsArray(): void
    {
        $this->assertSame(
            [1, 2, 3],
            (new ListOf(1, 2, 3))->value(),
            'Expected variadic items to be exposed verbatim',
        );
    }

    #[Test]
    public function countsItems(): void
    {
        $this->assertCount(3, new ListOf('a', 'b', 'c'));
    }

    #[Test]
    public function iteratesInInsertionOrder(): void
    {
        $collected = [];
        foreach (new ListOf(10, 20, 30) as $value) {
            $collected[] = $value;
        }
        $this->assertSame([10, 20, 30], $collected);
    }

    #[Test]
    public function emptyListHasZeroCount(): void
    {
        $this->assertCount(0, new ListOf());
    }

    #[Test]
    public function itemsFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new ListOf(1, 2, 3))->value(),
            ListOf::items(1, 2, 3)->value(),
        );
    }

    #[Test]
    public function itemsFactoryAgreesWithPrimaryConstructorForMixedValues(): void
    {
        $object = new \stdClass();

        self::assertSame(
            (new ListOf(1, 'two', null, $object))->value(),
            ListOf::items(1, 'two', null, $object)->value(),
        );
    }

    #[Test]
    public function itemsFactoryAgreesWithPrimaryConstructorForNoValues(): void
    {
        self::assertSame(
            (new ListOf())->value(),
            ListOf::items()->value(),
        );
    }
}
