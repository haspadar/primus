<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;

/**
 * Product of zero or more Number factors.
 *
 * Each operand contributes its float projection; the int accessor
 * truncates the resulting product toward zero. An empty product
 * yields one on both accessors (multiplicative identity).
 *
 * Example:
 *     $product = new MultOf(new NumberOf(2), new NumberOf(2.5));
 *     $product->asInt(); // 5
 *     $product->asFloat(); // 5.0
 */
final readonly class MultOf implements Number
{
    /** @var array<array-key, Number> */
    private array $factors;

    /**
     * Ctor.
     *
     * @param Number ...$factors The numbers to multiply.
     */
    public function __construct(Number ...$factors)
    {
        $this->factors = $factors;
    }

    #[Override]
    public function asInt(): int
    {
        return (int) $this->asFloat();
    }

    #[Override]
    public function asFloat(): float
    {
        $total = (float) 1;

        foreach ($this->factors as $factor) {
            $total *= $factor->asFloat();
        }

        return $total;
    }
}
