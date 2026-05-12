<?php

declare(strict_types=1);

namespace Primus\Tests\Bytes;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Bytes\RandomBytes;

final class RandomBytesTest extends TestCase
{
    #[Test]
    public function producesRequestedLength(): void
    {
        $this->assertSame(16, strlen((new RandomBytes(16))->value()));
    }

    #[Test]
    public function producesAnotherRequestedLength(): void
    {
        $this->assertSame(32, strlen((new RandomBytes(32))->value()));
    }

    #[Test]
    public function consecutiveCallsDifferOnSameInstance(): void
    {
        $bytes = new RandomBytes(16);

        $this->assertNotSame($bytes->value(), $bytes->value());
    }
}
