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

        self::assertSame($only, (new RootCause($only))->value());
    }

    #[Test]
    public function unwrapsTwoLevelChainToDeepest(): void
    {
        $inner = new RuntimeException('inner');
        $outer = new RuntimeException('outer', 0, $inner);

        self::assertSame($inner, (new RootCause($outer))->value());
    }

    #[Test]
    public function unwrapsDeepChainToDeepest(): void
    {
        $deepest = new RuntimeException('deepest');
        $middle = new RuntimeException('middle', 0, $deepest);
        $outer = new RuntimeException('outer', 0, $middle);

        self::assertSame($deepest, (new RootCause($outer))->value());
    }

    #[Test]
    public function repeatedCallsReturnSameInstance(): void
    {
        $inner = new RuntimeException('inner');
        $outer = new RuntimeException('outer', 0, $inner);

        $root = new RootCause($outer);

        self::assertSame($root->value(), $root->value());
    }

    #[Test]
    public function ofThrowableFactoryAgreesWithPrimaryConstructor(): void
    {
        $inner = new RuntimeException('inner');
        $outer = new RuntimeException('outer', 0, $inner);

        self::assertSame(
            (new RootCause($outer))->value(),
            RootCause::ofThrowable($outer)->value(),
        );
    }
}
