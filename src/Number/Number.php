<?php

declare(strict_types=1);

namespace Primus\Number;

/**
 * Represents a numeric value with explicit int and float accessors.
 *
 * Truncation toward zero on the int accessor follows native PHP `(int)` cast
 * semantics; the float accessor preserves the source magnitude.
 */
interface Number
{
    /**
     * Returns the integer projection of this number, truncated toward zero.
     */
    public function asInt(): int;

    /**
     * Returns the float projection of this number.
     */
    public function asFloat(): float;
}
