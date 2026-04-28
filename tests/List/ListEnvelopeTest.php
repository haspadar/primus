<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\List_;
use Primus\List\ListEnvelope;
use Primus\List\ListOf;

final class ListEnvelopeTest extends TestCase
{
    #[Test]
    public function delegatesValueToOrigin(): void
    {
        $this->assertSame(
            [1, 2, 3],
            $this->wrap(new ListOf(1, 2, 3))->value(),
        );
    }

    #[Test]
    public function delegatesCountToOrigin(): void
    {
        $this->assertCount(3, $this->wrap(new ListOf('a', 'b', 'c')));
    }

    #[Test]
    public function delegatesIterationToOrigin(): void
    {
        $collected = [];
        foreach ($this->wrap(new ListOf(10, 20, 30)) as $value) {
            $collected[] = $value;
        }
        $this->assertSame([10, 20, 30], $collected);
    }

    /**
     * @param List_<mixed> $origin
     */
    private function wrap(List_ $origin): ListEnvelope
    {
        return new readonly class ($origin) extends ListEnvelope {};
    }
}
