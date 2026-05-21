<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map with pairs ordered by ascending value comparison, keys preserved.
 *
 * Uses PHP's spaceship operator on every value pair, which yields ascending
 * order and stable ordering between pairs whose values compare equal.
 *
 * Example:
 *     $sorted = new Sorted(new MapOf(['b' => 3, 'a' => 1, 'c' => 2]));
 *     // ['a' => 1, 'c' => 2, 'b' => 3]
 *
 * @template K of array-key
 * @template V
 * @extends MapEnvelope<K, V>
 */
final readonly class Sorted extends MapEnvelope
{
    #[Override]
    public function value(): array
    {
        $pairs = $this->origin->value();
        uasort($pairs, static fn(mixed $left, mixed $right): int => $left <=> $right);

        return $pairs;
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
