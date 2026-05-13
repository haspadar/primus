<?php

declare(strict_types=1);

namespace Primus\Tests\Scalar;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Scalar\RootCause;
use RuntimeException;

final class RootCauseTest extends TestCase
{
    #[Test]
    public function returnsInputWhenChainIsSingle(): void
    {
        $only = new RuntimeException('only');

        $this->assertSame($only, (new RootCause($only))->value());
    }

    #[Test]
    public function unwrapsTwoLevelChainToDeepest(): void
    {
        $inner = new RuntimeException('inner');
        $outer = new RuntimeException('outer', 0, $inner);

        $this->assertSame($inner, (new RootCause($outer))->value());
    }

    #[Test]
    public function unwrapsDeepChainToDeepest(): void
    {
        $deepest = new RuntimeException('deepest');
        $middle = new RuntimeException('middle', 0, $deepest);
        $outer = new RuntimeException('outer', 0, $middle);

        $this->assertSame($deepest, (new RootCause($outer))->value());
    }

    #[Test]
    public function repeatedCallsReturnSameInstance(): void
    {
        $inner = new RuntimeException('inner');
        $outer = new RuntimeException('outer', 0, $inner);

        $root = new RootCause($outer);

        $this->assertSame($root->value(), $root->value());
    }
}
