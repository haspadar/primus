<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\Keys;
use Primus\Map\MapOf;

final class KeysTest extends TestCase
{
    #[Test]
    public function exposesKeysOfEmptyMapAsEmptyList(): void
    {
        $this->assertSame([], (new Keys(new MapOf([])))->value());
    }

    #[Test]
    public function exposesKeysInSourceOrder(): void
    {
        $this->assertSame(
            ['a', 'b', 'c'],
            (new Keys(new MapOf(['a' => 1, 'b' => 2, 'c' => 3])))->value(),
        );
    }

    #[Test]
    public function preservesMixedIntegerAndStringKeys(): void
    {
        $this->assertSame(
            [0, 'name', 7],
            (new Keys(new MapOf([0 => 'first', 'name' => 'Alice', 7 => 'lucky'])))->value(),
        );
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $keys = new Keys(new MapOf(['x' => 1, 'y' => 2]));
        $this->assertSame(
            $keys->value(),
            iterator_to_array($keys),
        );
    }

    #[Test]
    public function countsAsManyAsPairsInSource(): void
    {
        $this->assertCount(
            3,
            new Keys(new MapOf(['a' => 1, 'b' => 2, 'c' => 3])),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2]);
        $keys = new Keys($source);
        $keys->value();
        iterator_to_array($keys);
        $this->assertSame(['a' => 1, 'b' => 2], $source->value());
    }
}
