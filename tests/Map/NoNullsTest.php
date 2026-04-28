<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\MapOf;
use Primus\Map\NoNulls;
use RuntimeException;

final class NoNullsTest extends TestCase
{
    #[Test]
    public function yieldsSourceUnchangedWhenNoNulls(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2],
            (new NoNulls(new MapOf(['a' => 1, 'b' => 2])))->value(),
        );
    }

    #[Test]
    public function iteratesOverNonNullPairs(): void
    {
        $collected = [];
        foreach (new NoNulls(new MapOf(['x' => 10, 'y' => 20])) as $key => $value) {
            $collected[$key] = $value;
        }
        $this->assertSame(['x' => 10, 'y' => 20], $collected);
    }

    #[Test]
    public function throwsOnNullDuringIteration(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Null value encountered in NoNulls map');
        iterator_to_array(new NoNulls(new MapOf(['a' => 1, 'b' => null])));
    }

    #[Test]
    public function throwsOnNullWhenAccessingValue(): void
    {
        $this->expectException(RuntimeException::class);
        (new NoNulls(new MapOf(['x' => 'ok', 'y' => null])))->value();
    }

    #[Test]
    public function throwsOnNullWhenCounting(): void
    {
        $this->expectException(RuntimeException::class);
        (new NoNulls(new MapOf(['a' => 1, 'b' => null, 'c' => 3])))->count();
    }
}
