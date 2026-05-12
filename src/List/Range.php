<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * Finite arithmetic sequence of integers between two endpoints.
 *
 * The direction is determined by the relation between start and end:
 * an ascending sequence when start <= end, descending when start > end.
 * The step is always positive; it is the absolute distance between
 * consecutive elements.
 *
 * Example:
 *     $list = new Range(1, 7, 2);
 *     foreach ($list as $value) {
 *         echo $value;
 *     }
 *     // 1357
 *
 * @implements List_<int>
 */
final readonly class Range implements List_
{
    /**
     * Ctor.
     *
     * @param int $start The first value of the sequence.
     * @param int $end The last reachable value not crossing the endpoint.
     * @param int $step The positive distance between consecutive values.
     */
    public function __construct(private int $start, private int $end, private int $step = 1) {}

    #[Override]
    public function value(): array
    {
        return range($this->start, $this->end, $this->step);
    }

    #[Override]
    public function count(): int
    {
        return count($this->value());
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
