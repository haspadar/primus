<?php

declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiProcOf;

/**
 */
final class BiProcOfTest extends TestCase
{
    #[Test]
    public function executesClosureWithTwoInputs(): void
    {
        $sum = 0;

        (new BiProcOf(function (int $a, int $b) use (&$sum): void {
            $sum = $a + $b;
        }))->exec(2, 3);

        self::assertSame(5, $sum, 'BiProcOf must modify the state as expected');
    }

    #[Test]
    public function closureFactoryAgreesWithPrimaryConstructor(): void
    {
        $primary = 0;
        $factory = 0;
        $closurePrimary = static function (int $a, int $b) use (&$primary): void {
            $primary = $a + $b;
        };
        $closureFactory = static function (int $a, int $b) use (&$factory): void {
            $factory = $a + $b;
        };

        (new BiProcOf($closurePrimary))->exec(2, 3);
        BiProcOf::closure($closureFactory)->exec(2, 3);

        self::assertSame($primary, $factory);
    }
}
