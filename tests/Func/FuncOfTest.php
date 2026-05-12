<?php

declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\FuncOf;

/**
 */
final class FuncOfTest extends TestCase
{
    #[Test]
    public function appliesClosureToInput(): void
    {
        $func = new FuncOf(fn (int $x): int => $x * 2);
        self::assertSame(6, $func->apply(3), 'Doubles input value');
    }
}
