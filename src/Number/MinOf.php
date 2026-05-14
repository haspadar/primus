<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;
use UnderflowException;

/**
 * Smallest of one or more Number operands.
 *
 * Each accessor compares the corresponding projection of every operand
 * and returns the minimum. An empty operand list rejects access.
 *
 * Example:
 *     $min = new MinOf(new NumberOf(3), new NumberOf(-1), new NumberOf(2));
 *     $min->asInt(); // -1
 */
final readonly class MinOf implements Number
{
    /** @var array<array-key, Number> */
    private array $numbers;

    /**
     * Ctor.
     *
     * @param Number ...$numbers The numbers to compare.
     */
    public function __construct(Number ...$numbers)
    {
        $this->numbers = $numbers;
    }

    #[Override]
    public function asInt(): int
    {
        if ($this->numbers === []) {
            throw new UnderflowException('Cannot compute minimum of empty operand list');
        }

        return min(array_map(static fn(Number $n): int => $n->asInt(), $this->numbers));
    }

    #[Override]
    public function asFloat(): float
    {
        if ($this->numbers === []) {
            throw new UnderflowException('Cannot compute minimum of empty operand list');
        }

        return min(array_map(static fn(Number $n): float => $n->asFloat(), $this->numbers));
    }

    #[Override]
    public function asText(): string
    {
        return (string) $this->asFloat();
    }
}
