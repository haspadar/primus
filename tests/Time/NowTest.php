<?php

declare(strict_types=1);

namespace Primus\Tests\Time;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Time\Now;

final class NowTest extends TestCase
{
    #[Test]
    public function returnsRecentMoment(): void
    {
        $before = time();
        $now = (new Now())->value()->getTimestamp();
        $after = time();

        $this->assertGreaterThanOrEqual($before, $now);
        $this->assertLessThanOrEqual($after, $now);
    }

    #[Test]
    public function repeatedCallsCaptureDistinctReads(): void
    {
        $now = new Now();
        $first = $now->value();
        usleep(2000);
        $second = $now->value();

        $this->assertGreaterThanOrEqual($first, $second);
    }
}
