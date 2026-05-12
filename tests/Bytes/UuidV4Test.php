<?php

declare(strict_types=1);

namespace Primus\Tests\Bytes;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Bytes\BytesOf;
use Primus\Bytes\HexEncoded;
use Primus\Bytes\RandomBytes;
use Primus\Bytes\UuidV4;

final class UuidV4Test extends TestCase
{
    #[Test]
    public function valueIsSixteenBytes(): void
    {
        $this->assertSame(16, strlen((new UuidV4(new RandomBytes(16)))->value()));
    }

    #[Test]
    public function versionNibbleIsFour(): void
    {
        $bytes = (new UuidV4(new RandomBytes(16)))->value();

        $this->assertSame(0x40, ord($bytes[6]) & 0xF0);
    }

    #[Test]
    public function variantBitsAreRfc9562(): void
    {
        $bytes = (new UuidV4(new RandomBytes(16)))->value();

        $this->assertSame(0x80, ord($bytes[8]) & 0xC0);
    }

    #[Test]
    public function consecutiveCallsRereadSource(): void
    {
        $uuid = new UuidV4(new RandomBytes(16));

        $this->assertNotSame($uuid->value(), $uuid->value());
    }

    #[Test]
    public function preservesNonVersionVariantBitsFromSource(): void
    {
        $source = new BytesOf(str_repeat("\x00", 16));

        $bytes = (new UuidV4($source))->value();

        $this->assertSame("\x00\x00\x00\x00\x00\x00\x40\x00\x80\x00\x00\x00\x00\x00\x00\x00", $bytes);
    }

    #[Test]
    public function composesWithHexEncodedToCanonicalForm(): void
    {
        $source = new BytesOf(str_repeat("\xff", 16));

        $this->assertSame(
            'ffffffffffff4fffbfffffffffffffff',
            (new HexEncoded(new UuidV4($source)))->value(),
        );
    }

    #[Test]
    public function rejectsTooShortSource(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new UuidV4(new BytesOf('short')))->value();
    }
}
