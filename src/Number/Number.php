<?php

declare(strict_types=1);

namespace Primus\Number;

/**
 * Represents a numeric value with explicit int, float and text projections.
 *
 * Truncation toward zero on the int accessor follows native PHP `(int)` cast
 * semantics; the float accessor preserves the source magnitude; the text
 * accessor returns the string form of the float projection — integer values
 * render without a trailing `.0`, fractional values render in PHP's default
 * decimal format.
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

    /**
     * Returns the canonical decimal text projection of this number.
     */
    public function asString(): string;
}
