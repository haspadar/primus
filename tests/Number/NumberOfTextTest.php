<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\NumberOfText;
use Primus\Text\TextOf;

final class NumberOfTextTest extends TestCase
{
    #[Test]
    public function parsesIntegerString(): void
    {
        $this->assertSame(42, (new NumberOfText(new TextOf('42')))->asInt());
    }

    #[Test]
    public function parsesFloatString(): void
    {
        $this->assertSame(3.14, (new NumberOfText(new TextOf('3.14')))->asFloat());
    }

    #[Test]
    public function truncatesParsedFloatTowardZero(): void
    {
        $this->assertSame(3, (new NumberOfText(new TextOf('3.7')))->asInt());
    }

    #[Test]
    public function parsesNegativeIntegerString(): void
    {
        $this->assertSame(-7, (new NumberOfText(new TextOf('-7')))->asInt());
    }

    #[Test]
    public function returnsFloatForIntegerString(): void
    {
        $this->assertSame(42.0, (new NumberOfText(new TextOf('42')))->asFloat());
    }
}
