<?php

declare(strict_types=1);

namespace Primus\Tests\Number\Fakes;

use Override;
use Primus\Number\Number;

/**
 * Number fake that counts how many times each projection is invoked.
 *
 * Used to verify caching behaviour of decorators such as {@see \Primus\Number\Sticky}.
 */
final class CountingNumber implements Number
{
    public int $intCalls = 0;
    public int $floatCalls = 0;
    public int $stringCalls = 0;

    public function __construct(
        private readonly int $intValue,
        private readonly float $floatValue,
        private readonly string $stringValue = '',
    ) {}

    #[Override]
    public function asInt(): int
    {
        ++$this->intCalls;

        return $this->intValue;
    }

    #[Override]
    public function asFloat(): float
    {
        ++$this->floatCalls;

        return $this->floatValue;
    }

    #[Override]
    public function asString(): string
    {
        ++$this->stringCalls;

        return $this->stringValue;
    }
}
