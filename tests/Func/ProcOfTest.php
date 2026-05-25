<?php

declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\ProcOf;
use Primus\Tests\Constraint\HasCallCount;
use Primus\Tests\CountCalls;

/**
 */
final class ProcOfTest extends TestCase
{
    #[Test]
    public function executesClosureWithInput(): void
    {
        $calls = new CountCalls();

        (new ProcOf(fn (int $x): int => $calls->record($x)))->exec(5);

        self::assertThat(
            $calls,
            new HasCallCount(1),
            'ProcOf must execute the closure exactly once'
        );
    }

    #[Test]
    public function closureFactoryAgreesWithPrimaryConstructor(): void
    {
        $primary = 0;
        $factory = 0;
        $closurePrimary = static function (int $x) use (&$primary): void {
            $primary = $x * 2;
        };
        $closureFactory = static function (int $x) use (&$factory): void {
            $factory = $x * 2;
        };

        (new ProcOf($closurePrimary))->exec(5);
        ProcOf::closure($closureFactory)->exec(5);

        self::assertSame($primary, $factory);
    }
}
