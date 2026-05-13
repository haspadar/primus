<?php

declare(strict_types=1);

namespace Primus\Tests\Func;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\ProcOf;
use Primus\Func\RunOnce;

final class RunOnceTest extends TestCase
{
    #[Test]
    public function delegatesOnFirstCall(): void
    {
        $received = [];

        $once = new RunOnce(new ProcOf(static function (string $input) use (&$received): void {
            $received[] = $input;
        }));

        $once->exec('alpha');

        $this->assertSame(['alpha'], $received);
    }

    #[Test]
    public function ignoresSubsequentCalls(): void
    {
        $received = [];

        $once = new RunOnce(new ProcOf(static function (string $input) use (&$received): void {
            $received[] = $input;
        }));

        $once->exec('first');
        $once->exec('second');
        $once->exec('third');

        $this->assertSame(['first'], $received);
    }
}
