<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;

/**
 * Number rounded to the given decimal precision.
 *
 * Rounding uses PHP's default half-away-from-zero mode. The int
 * accessor returns the float result truncated toward zero.
 *
 * Example:
 *     $n = new Rounded(new NumberOf(3.14159), 2);
 *     $n->asFloat(); // 3.14
 *
 * @since 0.3
 */
final readonly class Rounded extends NumberEnvelope
{
    /**
     * Ctor.
     *
     * @param Number $origin The number to round.
     * @param int $precision The number of decimal digits to keep.
     */
    public function __construct(Number $origin, private int $precision)
    {
        parent::__construct($origin);
    }

    #[Override]
    public function asInt(): int
    {
        return (int) $this->asFloat();
    }

    #[Override]
    public function asFloat(): float
    {
        return round($this->origin->asFloat(), $this->precision);
    }
}
