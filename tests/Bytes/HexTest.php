<?php

declare(strict_types=1);

namespace Primus\Tests\Bytes;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Bytes\BytesOf;
use Primus\Bytes\HexDecoded;
use Primus\Bytes\HexEncoded;
use Primus\Text\TextOf;

final class HexTest extends TestCase
{
    #[Test]
    public function encodesAsciiToLowercaseHex(): void
    {
        $this->assertSame('6869', (new HexEncoded(new BytesOf('hi')))->value());
    }

    #[Test]
    public function encodesEmptyBytesToEmptyString(): void
    {
        $this->assertSame('', (new HexEncoded(new BytesOf('')))->value());
    }

    #[Test]
    public function encodesBinaryBytesIncludingHighRange(): void
    {
        $this->assertSame('00ff', (new HexEncoded(new BytesOf("\x00\xff")))->value());
    }

    #[Test]
    public function decodesHexBackToOriginal(): void
    {
        $this->assertSame('hi', (new HexDecoded(new TextOf('6869')))->value());
    }

    #[Test]
    public function decodesEmptyStringToEmptyBytes(): void
    {
        $this->assertSame('', (new HexDecoded(new TextOf('')))->value());
    }

    #[Test]
    public function roundTripPreservesBinaryBytesWithNulls(): void
    {
        $bytes = "\x00\x01\xff\xfe";
        $this->assertSame(
            $bytes,
            (new HexDecoded(new TextOf((new HexEncoded(new BytesOf($bytes)))->value())))->value(),
        );
    }

    #[Test]
    public function rejectsOddLengthHexInput(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new HexDecoded(new TextOf('abc')))->value();
    }

    #[Test]
    public function rejectsNonHexCharacters(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new HexDecoded(new TextOf('zz')))->value();
    }
}
