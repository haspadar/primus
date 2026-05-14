<?php

declare(strict_types=1);

namespace Primus\IntNumber;

use Override;
use Primus\Text\Text;
use Primus\Text\TextOf;
use UnderflowException;

/**
 * Minimum of one or more IntNumber operands, computed in native PHP int arithmetic.
 *
 * Throws on an empty operand list — minimum is undefined without operands.
 *
 * Example:
 *     $min = new MinOf(new IntNumberOf(9), new IntNumberOf(3), new IntNumberOf(5));
 *     $min->asInt(); // 3
 */
final readonly class MinOf implements IntNumber
{
    /** @var array<array-key, IntNumber> */
    private array $operands;

    /**
     * Ctor.
     *
     * @param IntNumber ...$operands The integers to compare.
     */
    public function __construct(IntNumber ...$operands)
    {
        $this->operands = $operands;
    }

    #[Override]
    public function asInt(): int
    {
        if ($this->operands === []) {
            throw new UnderflowException('Cannot compute minimum of empty operand list');
        }

        return min(array_map(static fn(IntNumber $n): int => $n->asInt(), $this->operands));
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
