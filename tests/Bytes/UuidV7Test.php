<?php

declare(strict_types=1);

namespace Primus\Tests\Bytes;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Bytes\BytesOf;
use Primus\Bytes\HexEncoded;
use Primus\Bytes\RandomBytes;
use Primus\Bytes\UuidV7;
use Primus\Time\TimeOf;

final class UuidV7Test extends TestCase
{
    #[Test]
    public function valueIsSixteenBytes(): void
    {
        $this->assertSame(
            16,
            strlen((new UuidV7(new TimeOf('2026-05-12T12:00:00Z'), new RandomBytes(10)))->value()),
        );
    }

    #[Test]
    public function versionNibbleIsSeven(): void
    {
        $bytes = (new UuidV7(new TimeOf('2026-05-12T12:00:00Z'), new RandomBytes(10)))->value();

        $this->assertSame(0x70, ord($bytes[6]) & 0xF0);
    }

    #[Test]
    public function variantBitsAreRfc9562(): void
    {
        $bytes = (new UuidV7(new TimeOf('2026-05-12T12:00:00Z'), new RandomBytes(10)))->value();

        $this->assertSame(0x80, ord($bytes[8]) & 0xC0);
    }

    #[Test]
    public function encodesUnixMillisecondsAsBigEndianInLeadingSixBytes(): void
    {
        $time = new TimeOf('1970-01-01T00:00:00.001Z');
        $random = new BytesOf(str_repeat("\x00", 10));

        $bytes = (new UuidV7($time, $random))->value();

        $this->assertSame("\x00\x00\x00\x00\x00\x01", substr($bytes, 0, 6));
    }

    #[Test]
    public function encodesLaterTimestampAsHigherLeadingBytes(): void
    {
        $earlier = (new UuidV7(new TimeOf('2026-05-12T12:00:00Z'), new BytesOf(str_repeat("\x00", 10))))->value();
        $later = (new UuidV7(new TimeOf('2026-05-12T12:00:01Z'), new BytesOf(str_repeat("\x00", 10))))->value();

        $this->assertGreaterThan(substr($earlier, 0, 6), substr($later, 0, 6));
    }

    #[Test]
    public function preservesNonVersionVariantBitsFromRandomSource(): void
    {
        $time = new TimeOf('1970-01-01T00:00:00Z');
        $random = new BytesOf(str_repeat("\x00", 10));

        $bytes = (new UuidV7($time, $random))->value();

        $this->assertSame("\x00\x00\x00\x00\x00\x00\x70\x00\x80\x00\x00\x00\x00\x00\x00\x00", $bytes);
    }

    #[Test]
    public function composesWithHexEncodedToCanonicalForm(): void
    {
        $time = new TimeOf('1970-01-01T00:00:00Z');
        $random = new BytesOf(str_repeat("\xff", 10));

        $this->assertSame(
            '0000000000007fffbfffffffffffffff',
            (new HexEncoded(new UuidV7($time, $random)))->value(),
        );
    }

    #[Test]
    public function consecutiveCallsRereadSources(): void
    {
        $uuid = new UuidV7(new TimeOf('2026-05-12T12:00:00Z'), new RandomBytes(10));

        $this->assertNotSame($uuid->value(), $uuid->value());
    }

    #[Test]
    public function rejectsTooShortRandomSource(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new UuidV7(new TimeOf('2026-05-12T12:00:00Z'), new BytesOf('short')))->value();
    }
}
