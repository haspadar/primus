<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;

/**
 * Number with the sign of its origin flipped on both projections.
 *
 * Example:
 *     $n = new Negated(new NumberOf(3.5));
 *     $n->asInt(); // -3 (truncate toward zero applied to -3.5)
 *     $n->asFloat(); // -3.5
 *
 * @since 0.3
 */
final readonly class Negated implements Number
{
    /**
     * Ctor.
     *
     * @param Number $origin The number to negate.
     */
    public function __construct(private Number $origin) {}

    #[Override]
    public function asInt(): int
    {
        return -$this->origin->asInt();
    }

    #[Override]
    public function asFloat(): float
    {
        return -$this->origin->asFloat();
    }
}
