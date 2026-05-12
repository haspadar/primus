<?php

declare(strict_types=1);

namespace Primus\Tests\Number;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Number\MultOf;
use Primus\Number\NumberOf;

final class MultOfTest extends TestCase
{
    #[Test]
    public function multipliesTwoIntegers(): void
    {
        $this->assertSame(6, (new MultOf(new NumberOf(2), new NumberOf(3)))->asInt());
    }

    #[Test]
    public function multipliesMixedIntegerAndFloat(): void
    {
        $this->assertSame(5.0, (new MultOf(new NumberOf(2), new NumberOf(2.5)))->asFloat());
    }

    #[Test]
    public function multipliesAcrossManyFactors(): void
    {
        $this->assertSame(
            24,
            (new MultOf(
                new NumberOf(1),
                new NumberOf(2),
                new NumberOf(3),
                new NumberOf(4),
            ))->asInt(),
        );
    }

    #[Test]
    public function truncatesFractionalProductOnIntAccessor(): void
    {
        $this->assertSame(3, (new MultOf(new NumberOf(1.5), new NumberOf(2.5)))->asInt());
    }

    #[Test]
    public function flipsSignWhenOneFactorIsNegative(): void
    {
        $this->assertSame(-12, (new MultOf(new NumberOf(3), new NumberOf(-4)))->asInt());
    }

    #[Test]
    public function emptyProductIsOneInt(): void
    {
        $this->assertSame(1, (new MultOf())->asInt());
    }

    #[Test]
    public function emptyProductIsOneFloat(): void
    {
        $this->assertSame(1.0, (new MultOf())->asFloat());
    }

    #[Test]
    public function zeroFactorYieldsZero(): void
    {
        $this->assertSame(0, (new MultOf(new NumberOf(5), new NumberOf(0)))->asInt());
    }
}
