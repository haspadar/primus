<?php

declare(strict_types=1);

namespace Primus\Tests\Integer;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Integer\Sticky;
use Primus\Tests\Integer\Fakes\CountingInteger;

final class StickyTest extends TestCase
{
    #[Test]
    public function returnsSameIntOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new CountingInteger(42, 3.14));

        $this->assertSame(42, $sticky->asInt());
        $this->assertSame(42, $sticky->asInt());
    }

    #[Test]
    public function returnsSameFloatOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new CountingInteger(42, 3.14));

        $this->assertSame(3.14, $sticky->asFloat());
        $this->assertSame(3.14, $sticky->asFloat());
    }

    #[Test]
    public function returnsSameTextOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new CountingInteger(42, 3.14, '42'));

        $this->assertSame('42', $sticky->asText()->value());
        $this->assertSame('42', $sticky->asText()->value());
    }

    #[Test]
    public function returnsSameTextInstanceOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new CountingInteger(42, 3.14, '42'));

        $this->assertSame($sticky->asText(), $sticky->asText());
    }

    #[Test]
    public function callsOriginAsIntAtMostOnce(): void
    {
        $origin = new CountingInteger(42, 3.14);
        $sticky = new Sticky($origin);

        $sticky->asInt();
        $sticky->asInt();
        $sticky->asInt();

        $this->assertSame(1, $origin->intCalls);
    }

    #[Test]
    public function callsOriginAsFloatAtMostOnce(): void
    {
        $origin = new CountingInteger(42, 3.14);
        $sticky = new Sticky($origin);

        $sticky->asFloat();
        $sticky->asFloat();
        $sticky->asFloat();

        $this->assertSame(1, $origin->floatCalls);
    }

    #[Test]
    public function callsOriginAsTextAtMostOnce(): void
    {
        $origin = new CountingInteger(42, 3.14, '42');
        $sticky = new Sticky($origin);

        $sticky->asText();
        $sticky->asText();
        $sticky->asText();

        $this->assertSame(1, $origin->textCalls);
    }

    #[Test]
    public function cachesEmptyTextAsValidValue(): void
    {
        $origin = new CountingInteger(0, 0.0, '');
        $sticky = new Sticky($origin);

        $sticky->asText();
        $sticky->asText();

        $this->assertSame(1, $origin->textCalls);
    }

    #[Test]
    public function cachesProjectionsIndependently(): void
    {
        $origin = new CountingInteger(42, 3.14, '42');
        $sticky = new Sticky($origin);

        $sticky->asInt();
        $sticky->asFloat();
        $sticky->asText();

        $this->assertSame(1, $origin->intCalls);
        $this->assertSame(1, $origin->floatCalls);
        $this->assertSame(1, $origin->textCalls);
    }
}
