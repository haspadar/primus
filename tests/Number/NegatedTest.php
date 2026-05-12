<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\Negated;
use Primus\Number\NumberOf;

final class NegatedTest extends TestCase
{
    #[Test]
    public function flipsSignOfPositiveInteger(): void
    {
        $this->assertSame(-5, (new Negated(new NumberOf(5)))->asInt());
    }

    #[Test]
    public function flipsSignOfNegativeInteger(): void
    {
        $this->assertSame(7, (new Negated(new NumberOf(-7)))->asInt());
    }

    #[Test]
    public function flipsSignOfPositiveFloat(): void
    {
        $this->assertSame(-3.5, (new Negated(new NumberOf(3.5)))->asFloat());
    }

    #[Test]
    public function flipsSignOfNegativeFloat(): void
    {
        $this->assertSame(2.7, (new Negated(new NumberOf(-2.7)))->asFloat());
    }

    #[Test]
    public function doubleNegationRestoresIntProjection(): void
    {
        $this->assertSame(42, (new Negated(new Negated(new NumberOf(42))))->asInt());
    }

    #[Test]
    public function doubleNegationRestoresFloatProjection(): void
    {
        $this->assertSame(3.14, (new Negated(new Negated(new NumberOf(3.14))))->asFloat());
    }

    #[Test]
    public function negatedZeroIsZeroInt(): void
    {
        $this->assertSame(0, (new Negated(new NumberOf(0)))->asInt());
    }

    #[Test]
    public function negatedZeroFloatEqualsZero(): void
    {
        $this->assertSame(0.0, abs((new Negated(new NumberOf(0.0)))->asFloat()));
    }
}
