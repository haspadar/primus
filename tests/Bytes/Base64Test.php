<?php

declare(strict_types=1);

namespace Primus\Tests\Bytes;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Bytes\Base64Decoded;
use Primus\Bytes\Base64Encoded;
use Primus\Bytes\BytesOf;
use Primus\Text\TextOf;

final class Base64Test extends TestCase
{
    #[Test]
    public function encodesAsciiToCanonicalBase64(): void
    {
        $this->assertSame('aGVsbG8=', (new Base64Encoded(new BytesOf('hello')))->value());
    }

    #[Test]
    public function encodesEmptyBytesToEmptyString(): void
    {
        $this->assertSame('', (new Base64Encoded(new BytesOf('')))->value());
    }

    #[Test]
    public function decodesBase64BackToOriginal(): void
    {
        $this->assertSame('hello', (new Base64Decoded(TextOf::str('aGVsbG8=')))->value());
    }

    #[Test]
    public function decodesEmptyStringToEmptyBytes(): void
    {
        $this->assertSame('', (new Base64Decoded(TextOf::str('')))->value());
    }

    #[Test]
    public function roundTripPreservesBinaryBytesWithNulls(): void
    {
        $bytes = "\x00\x01\xff\xfe";
        $this->assertSame(
            $bytes,
            (new Base64Decoded(TextOf::str((new Base64Encoded(new BytesOf($bytes)))->value())))->value(),
        );
    }

    #[Test]
    public function rejectsInvalidBase64Input(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new Base64Decoded(TextOf::str('not_valid!!!')))->value();
    }
}
