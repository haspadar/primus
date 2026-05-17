<?php

declare(strict_types=1);

namespace Primus\Tests\Decimal\Fakes;

use Override;
use Primus\Decimal\Decimal;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Decimal fake that counts how many times asString is invoked.
 *
 * Used to verify caching behaviour of {@see \Primus\Decimal\Sticky}.
 */
final class CountingDecimal implements Decimal
{
    public int $stringCalls = 0;

    /**
     * Ctor.
     *
     * @param numeric-string $value Numeric string returned from every projection.
     */
    public function __construct(private readonly string $value) {}

    #[Override]
    public function asInt(): int
    {
        return (int) $this->value;
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->value;
    }

    #[Override]
    public function asText(): Text
    {
        return TextOf::str($this->value);
    }

    #[Override]
    public function asString(): string
    {
        ++$this->stringCalls;

        return $this->value;
    }
}
