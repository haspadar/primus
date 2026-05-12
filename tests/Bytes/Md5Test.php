<?php

declare(strict_types=1);

namespace Primus\Tests\Bytes;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Bytes\BytesOf;
use Primus\Bytes\HexEncoded;
use Primus\Bytes\Md5;

final class Md5Test extends TestCase
{
    #[Test]
    public function digestOfAsciiMatchesKnownHex(): void
    {
        $this->assertSame(
            '5d41402abc4b2a76b9719d911017c592',
            (new HexEncoded(new Md5(new BytesOf('hello'))))->value(),
        );
    }

    #[Test]
    public function digestOfEmptyMatchesKnownHex(): void
    {
        $this->assertSame(
            'd41d8cd98f00b204e9800998ecf8427e',
            (new HexEncoded(new Md5(new BytesOf(''))))->value(),
        );
    }

    #[Test]
    public function rawDigestIsSixteenBytes(): void
    {
        $this->assertSame(16, strlen((new Md5(new BytesOf('hello')))->value()));
    }

    #[Test]
    public function repeatedCallsReturnSameDigest(): void
    {
        $md5 = new Md5(new BytesOf('hello'));

        $this->assertSame($md5->value(), $md5->value());
    }
}
