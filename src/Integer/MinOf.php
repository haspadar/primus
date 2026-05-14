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
 * Example:
 *     $min = new MinOf(new IntegerOf(9), new IntegerOf(3), new IntegerOf(5));
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
        return new TextOf((string) $this->asInt());
    }
}
