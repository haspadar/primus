<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;

/**
 * Number rounded to the given decimal precision on the float projection.
 *
 * Rounding uses PHP's default half-away-from-zero mode. The int accessor
 * returns the origin int unchanged: rounding to a decimal precision is
 * undefined for the integer projection.
 *
 * Example:
 *     $n = new Rounded(new NumberOf(3.14159), 2);
 *     $n->asFloat(); // 3.14
 *     $n->asInt(); // 3 (origin int, unaffected by precision)
 *
 * @since 0.3
 */
final readonly class Rounded implements Number
{
    /**
     * Ctor.
     *
     * @param Number $origin The number to round.
     * @param int $precision The number of decimal digits to keep.
     */
    public function __construct(private Number $origin, private int $precision) {}

    #[Override]
    public function asInt(): int
    {
        return $this->origin->asInt();
    }

    #[Override]
    public function asFloat(): float
    {
        return round($this->origin->asFloat(), $this->precision);
    }
}
