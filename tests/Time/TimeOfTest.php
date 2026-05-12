<?php

declare(strict_types=1);

namespace Primus\Tests\Time;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Time\TimeOf;

final class TimeOfTest extends TestCase
{
    #[Test]
    public function parsesIsoDateTime(): void
    {
        $this->assertSame(
            '2026-05-12T10:00:00+00:00',
            (new TimeOf('2026-05-12T10:00:00Z'))->value()->format('c'),
        );
    }

    #[Test]
    public function parsesDateOnlyAsMidnight(): void
    {
        $this->assertSame(
            '2026-05-12 00:00:00',
            (new TimeOf('2026-05-12'))->value()->format('Y-m-d H:i:s'),
        );
    }

    #[Test]
    public function repeatedCallsReturnEqualValues(): void
    {
        $time = new TimeOf('2026-05-12T10:00:00Z');

        $this->assertEquals($time->value(), $time->value());
    }
}
