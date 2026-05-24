<?php

declare(strict_types=1);

namespace Primus\List;

use Generator;
use Override;

/**
 * List with elements ordered by built-in value comparison.
 *
 * Uses PHP's spaceship operator on every pair, which yields ascending order
 * and stable ordering between equal items.
 *
 * Construction forms:
 *
 * - `new Sorted(List_)` — wrap an existing {@see List_}.
 * - `Sorted::ofList(List_)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $sorted = Sorted::ofList(new ListOf(3, 1, 2));
 *     // [1, 2, 3]
 *
 * @template T
 * @extends ListEnvelope<T>
 */
final readonly class Sorted extends ListEnvelope
{
    /**
     * Sorts elements of a {@see List_} by PHP's spaceship comparison.
     *
     * @template U
     * @param List_<U> $list The list whose elements are sorted.
     * @return self<U>
     * @psalm-api
     */
    public static function ofList(List_ $list): self
    {
        return new self($list);
    }

    #[Override]
    public function value(): array
    {
        $items = $this->origin->value();
        usort($items, static fn(mixed $left, mixed $right): int => $left <=> $right);

        return $items;
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
