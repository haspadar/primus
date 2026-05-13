<?php

declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\ForEach_;
use Primus\Func\ProcOf;
use Primus\List\ListOf;

final class ForEach_Test extends TestCase
{
    #[Test]
    public function appliesProcToEachElementInOrder(): void
    {
        $collected = [];

        (new ForEach_(
            new ListOf('a', 'b', 'c'),
            new ProcOf(static function (string $s) use (&$collected): void {
                $collected[] = $s;
            }),
        ))->exec();

        $this->assertSame(['a', 'b', 'c'], $collected);
    }

    #[Test]
    public function emptyListIsNoOp(): void
    {
        $calls = 0;

        (new ForEach_(
            new ListOf(),
            new ProcOf(static function () use (&$calls): void {
                ++$calls;
            }),
        ))->exec();

        $this->assertSame(0, $calls);
    }

}
