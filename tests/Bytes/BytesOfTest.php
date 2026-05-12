<?php

declare(strict_types=1);

namespace Primus\Tests\Bytes;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Bytes\BytesOf;

final class BytesOfTest extends TestCase
{
    #[Test]
    public function returnsWrappedStringUnchanged(): void
    {
        $this->assertSame('hello', (new BytesOf('hello'))->value());
    }

    #[Test]
    public function returnsEmptyStringUnchanged(): void
    {
        $this->assertSame('', (new BytesOf(''))->value());
    }

    #[Test]
    public function preservesBinaryBytesWithNulls(): void
    {
        $this->assertSame("\x00\x01\xff", (new BytesOf("\x00\x01\xff"))->value());
    }
}
