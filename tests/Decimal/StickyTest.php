<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Decimal\Decimal;
use Primus\Decimal\DecimalOf;
use Primus\Decimal\Sticky;

final class StickyTest extends TestCase
{
    #[Test]
    public function preservesDecimalType(): void
    {
        $this->assertInstanceOf(Decimal::class, new Sticky(new DecimalOf('3.14')));
    }

    #[Test]
    public function returnsSameIntOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new DecimalOf('3.14'));

        $this->assertSame(3, $sticky->asInt());
        $this->assertSame(3, $sticky->asInt());
    }

    #[Test]
    public function returnsSameFloatOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new DecimalOf('3.14'));

        $this->assertSame(3.14, $sticky->asFloat());
        $this->assertSame(3.14, $sticky->asFloat());
    }

    #[Test]
    public function returnsSameStringOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new DecimalOf('3.14'));

        $this->assertSame('3.14', $sticky->asString());
        $this->assertSame('3.14', $sticky->asString());
    }

    #[Test]
    public function returnsSameTextInstanceOnRepeatedCalls(): void
    {
        $sticky = new Sticky(new DecimalOf('3.14'));

        $this->assertSame($sticky->asText(), $sticky->asText());
    }
}
