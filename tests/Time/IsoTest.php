<?php

declare(strict_types=1);

namespace Primus\Tests\Time;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Time\Iso;
use Primus\Time\TimeOf;

final class IsoTest extends TestCase
{
    #[Test]
    public function formatsUtcMomentWithOffset(): void
    {
        $this->assertSame(
            '2026-05-12T10:00:00+00:00',
            (new Iso(new TimeOf('2026-05-12T10:00:00Z')))->value(),
        );
    }

    #[Test]
    public function preservesOffsetFromInput(): void
    {
        $this->assertSame(
            '2026-05-12T13:00:00+03:00',
            (new Iso(new TimeOf('2026-05-12T13:00:00+03:00')))->value(),
        );
    }

    #[Test]
    public function formatsDateOnlyAsMidnightWithSystemOffset(): void
    {
        $iso = (new Iso(new TimeOf('2026-05-12')))->value();

        $this->assertStringStartsWith('2026-05-12T00:00:00', $iso);
    }

    #[Test]
    public function ofFactoryAgreesWithPrimaryConstructor(): void
    {
        $time = new TimeOf('2026-05-12T10:00:00Z');

        $this->assertSame(
            (new Iso($time))->value(),
            Iso::of($time)->value(),
        );
    }
}
