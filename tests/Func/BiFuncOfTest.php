<?php

declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiFuncOf;
use Primus\Tests\Constraint\AppliesBiFuncTo;

/**
 */
final class BiFuncOfTest extends TestCase
{
    #[Test]
    public function appliesClosureToTwoInputs(): void
    {
        self::assertThat(
            new BiFuncOf(fn (int $a, int $b): int => $a + $b),
            new AppliesBiFuncTo([3, 4], 7),
            'BiFuncOf must apply the closure to two inputs'
        );
    }

    #[Test]
    public function closureFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = static fn(int $a, int $b): int => $a + $b;

        self::assertSame(
            (new BiFuncOf($source))->apply(3, 4),
            BiFuncOf::closure($source)->apply(3, 4),
        );
    }
}
