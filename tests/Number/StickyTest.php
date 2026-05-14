<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\Sticky;
use Primus\Tests\Number\Fakes\CountingNumber;

final class StickyTest extends TestCase
{
    #[Test]
    public function returnsSameIntOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new CountingNumber(42, 3.14));

        $this->assertSame(42, $sticky->asInt());
        $this->assertSame(42, $sticky->asInt());
    }

    #[Test]
    public function returnsSameFloatOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new CountingNumber(42, 3.14));

        $this->assertSame(3.14, $sticky->asFloat());
        $this->assertSame(3.14, $sticky->asFloat());
    }

    #[Test]
    public function callsOriginAsIntAtMostOnce(): void
    {
        $origin = new CountingNumber(42, 3.14);
        $sticky = new Sticky($origin);

        $sticky->asInt();
        $sticky->asInt();
        $sticky->asInt();

        $this->assertSame(1, $origin->intCalls);
    }

    #[Test]
    public function callsOriginAsFloatAtMostOnce(): void
    {
        $origin = new CountingNumber(42, 3.14);
        $sticky = new Sticky($origin);

        $sticky->asFloat();
        $sticky->asFloat();
        $sticky->asFloat();

        $this->assertSame(1, $origin->floatCalls);
    }

    #[Test]
    public function cachesIntAndFloatIndependently(): void
    {
        $origin = new CountingNumber(42, 3.14);
        $sticky = new Sticky($origin);

        $sticky->asInt();
        $sticky->asFloat();

        $this->assertSame(1, $origin->intCalls);
        $this->assertSame(1, $origin->floatCalls);
    }

    #[Test]
    public function returnsSameTextOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new CountingNumber(42, 3.14, '3.14'));

        $this->assertSame('3.14', $sticky->asString());
        $this->assertSame('3.14', $sticky->asString());
    }

    #[Test]
    public function callsOriginAsTextAtMostOnce(): void
    {
        $origin = new CountingNumber(42, 3.14, '3.14');
        $sticky = new Sticky($origin);

        $sticky->asString();
        $sticky->asString();
        $sticky->asString();

        $this->assertSame(1, $origin->stringCalls);
    }

    #[Test]
    public function cachesProjectionsIndependently(): void
    {
        $origin = new CountingNumber(42, 3.14, '3.14');
        $sticky = new Sticky($origin);

        $sticky->asInt();
        $sticky->asFloat();
        $sticky->asString();

        $this->assertSame(1, $origin->intCalls);
        $this->assertSame(1, $origin->floatCalls);
        $this->assertSame(1, $origin->stringCalls);
    }
}
