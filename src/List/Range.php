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
 * Construction forms:
 *
 * - `new Range(int, int, int = 1)` — wrap start, end and step.
 * - `Range::ofBounds(int, int, int = 1)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $list = Range::ofBounds(1, 7, 2);
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

    /**
     * Builds a finite arithmetic sequence of integers between two endpoints.
     *
     * @param int $from The first value of the sequence.
     * @param int $upto The last reachable value not crossing the endpoint.
     * @param int $stride The positive distance between consecutive values.
     * @psalm-api
     */
    public static function ofBounds(int $from, int $upto, int $stride = 1): self
    {
        return new self($from, $upto, $stride);
    }

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
