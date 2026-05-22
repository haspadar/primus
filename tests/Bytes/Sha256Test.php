<?php

declare(strict_types=1);

namespace Primus\Tests\Bytes;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Bytes\BytesOf;
use Primus\Bytes\HexEncoded;
use Primus\Bytes\Sha256;

final class Sha256Test extends TestCase
{
    #[Test]
    public function digestOfAsciiMatchesKnownHex(): void
    {
        $this->assertSame(
            '2cf24dba5fb0a30e26e83b2ac5b9e29e1b161e5c1fa7425e73043362938b9824',
            (new HexEncoded(new Sha256(new BytesOf('hello'))))->value(),
        );
    }

    #[Test]
    public function digestOfEmptyMatchesKnownHex(): void
    {
        $this->assertSame(
            'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855',
            (new HexEncoded(new Sha256(new BytesOf(''))))->value(),
        );
    }

    #[Test]
    public function rawDigestIsThirtyTwoBytes(): void
    {
        $this->assertSame(32, strlen((new Sha256(new BytesOf('hello')))->value()));
    }

    #[Test]
    public function repeatedCallsReturnSameDigest(): void
    {
        $sha = new Sha256(new BytesOf('hello'));

        $this->assertSame($sha->value(), $sha->value());
    }

    #[Test]
    public function ofFactoryAgreesWithPrimaryConstructor(): void
    {
        $bytes = new BytesOf('hello');

        $this->assertSame(
            (new Sha256($bytes))->value(),
            Sha256::of($bytes)->value(),
        );
    }
}
