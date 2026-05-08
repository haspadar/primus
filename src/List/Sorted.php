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
 * Example:
 *     $sorted = new Sorted(new ListOf(3, 1, 2));
 *     // [1, 2, 3]
 *
 * @template T
 * @extends ListEnvelope<T>
 * @since 0.3
 */
final readonly class Sorted extends ListEnvelope
{
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
