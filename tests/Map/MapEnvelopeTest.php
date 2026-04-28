<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\Map;
use Primus\Map\MapEnvelope;
use Primus\Map\MapOf;

final class MapEnvelopeTest extends TestCase
{
    #[Test]
    public function delegatesValueToOrigin(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2],
            $this->wrap(new MapOf(['a' => 1, 'b' => 2]))->value(),
        );
    }

    #[Test]
    public function delegatesCountToOrigin(): void
    {
        $this->assertCount(3, $this->wrap(new MapOf(['x' => 1, 'y' => 2, 'z' => 3])));
    }

    #[Test]
    public function delegatesIterationToOrigin(): void
    {
        $collected = [];
        foreach ($this->wrap(new MapOf(['a' => 10, 'b' => 20])) as $key => $value) {
            $collected[$key] = $value;
        }
        $this->assertSame(['a' => 10, 'b' => 20], $collected);
    }

    /**
     * @param Map<array-key, mixed> $origin
     */
    private function wrap(Map $origin): MapEnvelope
    {
        return new readonly class ($origin) extends MapEnvelope {};
    }
}
