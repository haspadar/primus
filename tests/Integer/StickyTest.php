<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\Integer;
use Primus\Integer\IntegerOf;
use Primus\Integer\Sticky;

final class StickyTest extends TestCase
{
    #[Test]
    public function preservesIntegerType(): void
    {
        $this->assertInstanceOf(Integer::class, new Sticky(new IntegerOf(42)));
    }

    #[Test]
    public function returnsSameIntOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new IntegerOf(42));

        $this->assertSame(42, $sticky->asInt());
        $this->assertSame(42, $sticky->asInt());
    }

    #[Test]
    public function returnsSameFloatOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new IntegerOf(42));

        $this->assertSame(42.0, $sticky->asFloat());
        $this->assertSame(42.0, $sticky->asFloat());
    }

}
