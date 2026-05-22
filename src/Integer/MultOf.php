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
 * Construction forms:
 *
 * - `new MultOf(Integer ...)` — wrap an existing variadic list of integers.
 * - `MultOf::integers(Integer ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $product = MultOf::integers(IntegerOf::int(3), IntegerOf::int(4));
 *     $product->asInt(); // 12
 *     MultOf::integers()->asInt(); // 1 (multiplicative identity)
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

    /**
     * Multiplies variadic {@see Integer} factors.
     *
     * @param Integer ...$integers The integers to multiply.
     * @psalm-api
     */
    public static function integers(Integer ...$integers): self
    {
        return new self(...$integers);
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
