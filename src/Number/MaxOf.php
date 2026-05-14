<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;
use UnderflowException;

/**
 * Largest of one or more Number operands.
 *
 * Each accessor compares the corresponding projection of every operand
 * and returns the maximum. An empty operand list rejects access.
 *
 * Example:
 *     $max = new MaxOf(new NumberOf(3), new NumberOf(-1), new NumberOf(2));
 *     $max->asInt(); // 3
 */
final readonly class MaxOf implements Number
{
    /** @var array<array-key, Number> */
    private array $operands;

    /**
     * Ctor.
     *
     * @param Number ...$operands The numbers to compare.
     */
    public function __construct(Number ...$operands)
    {
        $this->operands = $operands;
    }

    #[Override]
    public function asInt(): int
    {
        if ($this->operands === []) {
            throw new UnderflowException('Cannot compute maximum of empty operand list');
        }

        return max(array_map(static fn(Number $n): int => $n->asInt(), $this->operands));
    }

    #[Override]
    public function asFloat(): float
    {
        if ($this->operands === []) {
            throw new UnderflowException('Cannot compute maximum of empty operand list');
        }

        return max(array_map(static fn(Number $n): float => $n->asFloat(), $this->operands));
    }

    #[Override]
    public function asText(): Text
    {
        return new TextOf((string) $this->asFloat());
    }
}
