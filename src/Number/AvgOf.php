<?php

declare(strict_types=1);

namespace Primus\Number;

use Override;

/**
 * Arithmetic mean of one or more Number operands.
 *
 * The float accessor sums operand float projections and divides by the
 * operand count. The int accessor truncates the resulting mean toward
 * zero. An empty operand list surfaces PHP's native DivisionByZeroError
 * at accessor time.
 *
 * Example:
 *     $avg = new AvgOf(new NumberOf(1), new NumberOf(2), new NumberOf(6));
 *     $avg->asFloat(); // 3.0
 *     $avg->asInt(); // 3
 */
final readonly class AvgOf implements Number
{
    /** @var array<array-key, Number> */
    private array $operands;

    /**
     * Ctor.
     *
     * @param Number ...$operands The numbers to average.
     */
    public function __construct(Number ...$operands)
    {
        $this->operands = $operands;
    }

    #[Override]
    public function asInt(): int
    {
        return (int) $this->asFloat();
    }

    #[Override]
    public function asFloat(): float
    {
        $total = (float) 0;

        foreach ($this->operands as $operand) {
            $total += $operand->asFloat();
        }

        return $total / (float) count($this->operands);
    }
}
