<?php

declare(strict_types=1);

namespace Primus\Integer;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;

/**
 * Sum of zero or more Integer addends, computed in native PHP int arithmetic.
 *
 * Each operand contributes its int projection; overflow follows native PHP
 * semantics (the result silently widens to float, breaking the int contract).
 * Callers are responsible for staying within PHP_INT_MAX.
 *
 * Construction forms:
 *
 * - `new SumOf(Integer ...)` — wrap an existing variadic list of integers.
 * - `SumOf::integers(Integer ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $sum = SumOf::integers(IntegerOf::int(2), IntegerOf::int(3));
 *     $sum->asInt(); // 5
 *     SumOf::integers()->asInt(); // 0 (additive identity)
 */
final readonly class SumOf implements Integer
{
    /** @var array<array-key, Integer> */
    private array $addends;

    /**
     * Ctor.
     *
     * @param Integer ...$addends The integers to add.
     */
    public function __construct(Integer ...$addends)
    {
        $this->addends = $addends;
    }

    /**
     * Sums variadic {@see Integer} addends.
     *
     * @param Integer ...$integers The integers to add.
     * @psalm-api
     */
    public static function integers(Integer ...$integers): self
    {
        return new self(...$integers);
    }

    #[Override]
    public function asInt(): int
    {
        $total = 0;

        foreach ($this->addends as $addend) {
            $total += $addend->asInt();
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
