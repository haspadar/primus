<?php

declare(strict_types=1);

namespace Primus\Integer;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Product of zero or more Integer factors, computed in native PHP int arithmetic.
 *
 * Each operand contributes its int projection; overflow follows native PHP
 * semantics (the result silently widens to float, breaking the int contract).
 * Callers are responsible for staying within PHP_INT_MAX.
 *
 * Example:
 *     $product = new MultOf(new IntegerOf(3), new IntegerOf(4));
 *     $product->asInt(); // 12
 *     (new MultOf())->asInt(); // 1 (multiplicative identity)
 */
final readonly class MultOf implements Integer
{
    /** @var array<array-key, Integer> */
    private array $factors;

    /**
     * Ctor.
     *
     * @param Integer ...$factors The integers to multiply.
     */
    public function __construct(Integer ...$factors)
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
        return TextOf::str((string) $this->asInt());
    }
}
