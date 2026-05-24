<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\ListOf;
use Primus\List\NoNulls;
use Primus\List\Reversed;
use RuntimeException;

final class NoNullsTest extends TestCase
{
    #[Test]
    public function yieldsSourceUnchangedWhenNoNulls(): void
    {
        $this->assertSame(
            [1, 2, 3],
            (new NoNulls(new ListOf(1, 2, 3)))->value(),
        );
    }

    #[Test]
    public function iteratesOverNonNullValues(): void
    {
        $collected = [];
        foreach (new NoNulls(new ListOf('a', 'b')) as $value) {
            $collected[] = $value;
        }
        $this->assertSame(['a', 'b'], $collected);
    }

    #[Test]
    public function throwsOnNullDuringIteration(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Null value encountered in NoNulls list');
        iterator_to_array(new NoNulls(new ListOf(1, null, 3)));
    }

    #[Test]
    public function throwsOnNullWhenAccessingValue(): void
    {
        $this->expectException(RuntimeException::class);
        (new NoNulls(new ListOf('x', null)))->value();
    }

    #[Test]
    public function throwsOnNullWhenCounting(): void
    {
        $this->expectException(RuntimeException::class);
        (new NoNulls(new ListOf(1, null, 3)))->count();
    }

    #[Test]
    public function composesWithReversed(): void
    {
        $this->assertSame(
            [3, 2, 1],
            (new Reversed(new NoNulls(new ListOf(1, 2, 3))))->value(),
        );
    }

    #[Test]
    public function ofListFactoryAgreesWithPrimaryConstructor(): void
    {
        $list = new ListOf(1, 2, 3);

        self::assertSame(
            (new NoNulls($list))->value(),
            NoNulls::ofList($list)->value(),
        );
    }
}
