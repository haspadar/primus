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
 * Construction forms:
 *
 * - `new Sorted(Map)` — wrap an existing {@see Map}.
 * - `Sorted::ofMap(Map)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $sorted = Sorted::ofMap(new MapOf(['b' => 3, 'a' => 1, 'c' => 2]));
 *     // ['a' => 1, 'c' => 2, 'b' => 3]
 *
 * @template K of array-key
 * @template V
 * @extends MapEnvelope<K, V>
 */
final readonly class Sorted extends MapEnvelope
{
    /**
     * Sorts pairs of a {@see Map} by ascending value comparison, keys preserved.
     *
     * @template L of array-key
     * @template W
     * @param Map<L, W> $map The map whose pairs are sorted by value.
     * @return self<L, W>
     * @psalm-api
     */
    public static function ofMap(Map $map): self
    {
        return new self($map);
    }

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
