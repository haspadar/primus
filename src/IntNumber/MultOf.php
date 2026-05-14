<?php

declare(strict_types=1);

namespace Primus\IntNumber;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Product of zero or more IntNumber factors, computed in native PHP int arithmetic.
 *
 * Each operand contributes its int projection; overflow follows native PHP
 * semantics (the result silently widens to float, breaking the int contract).
 * Callers are responsible for staying within PHP_INT_MAX.
 *
 * Example:
 *     $product = new MultOf(new IntNumberOf(3), new IntNumberOf(4));
 *     $product->asInt(); // 12
 *     (new MultOf())->asInt(); // 1 (multiplicative identity)
 */
final readonly class MultOf implements IntNumber
{
    /** @var array<array-key, IntNumber> */
    private array $factors;

    /**
     * Ctor.
     *
     * @param IntNumber ...$factors The integers to multiply.
     */
    public function __construct(IntNumber ...$factors)
    {
        $this->factors = $factors;
    }

    #[Override]
    public function asInt(): int
    {
        $total = 1;

        foreach ($this->factors as $factor) {
            $total *= $factor->asInt();
        }

        return $total;
    }

    #[Override]
    public function asFloat(): float
    {
        return (float) $this->asInt();
    }

    #[Override]
    public function asText(): Text
    {
        return new TextOf((string) $this->asInt());
    }
}
