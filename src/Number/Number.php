<?php

declare(strict_types=1);

namespace Primus\Number;

use Primus\Text\Text;

/**
 * Represents a numeric value with explicit int, float and text projections.
 *
 * Truncation toward zero on the int accessor follows native PHP `(int)` cast
 * semantics; the float accessor preserves the source magnitude; the text
 * accessor returns the canonical decimal form of the value, with the exact
 * format determined by the implementation family.
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
    public function asText(): Text;
}
