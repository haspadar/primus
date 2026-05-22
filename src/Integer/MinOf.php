<?php

declare(strict_types=1);

namespace Primus\Integer;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;
use UnderflowException;

/**
 * Minimum of one or more Integer operands, computed in native PHP int arithmetic.
 *
 * Throws on an empty operand list — minimum is undefined without operands.
 *
 * Construction forms:
 *
 * - `new MinOf(Integer ...)` — wrap an existing variadic list of integers.
 * - `MinOf::integers(Integer ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $min = MinOf::integers(IntegerOf::int(9), IntegerOf::int(3), IntegerOf::int(5));
 *     $min->asInt(); // 3
 */
final readonly class MinOf implements Integer
{
    /** @var array<array-key, Integer> */
    private array $operands;

    /**
     * Ctor.
     *
     * @param Integer ...$operands The integers to compare.
     */
    public function __construct(Integer ...$operands)
    {
        $this->operands = $operands;
    }

    /**
     * Selects the minimum of variadic {@see Integer} operands.
     *
     * @param Integer ...$integers The integers to compare.
     * @psalm-api
     */
    public static function integers(Integer ...$integers): self
    {
        return new self(...$integers);
    }

    #[Override]
    public function asInt(): int
    {
        if ($this->operands === []) {
            throw new UnderflowException('Cannot compute minimum of empty operand list');
        }

        return min(array_map(static fn(Integer $n): int => $n->asInt(), $this->operands));
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
