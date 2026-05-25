<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map built from an associative array.
 *
 * Construction forms:
 *
 * - `new MapOf(array)` — wrap the given associative array.
 * - `MapOf::pairs(array)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $map = MapOf::pairs(['a' => 1, 'b' => 2]);
 *     echo count($map); // 2
 *
 * @template K of array-key
 * @template V
 * @implements Map<K, V>
 */
final readonly class MapOf implements Map
{
    /**
     * Ctor.
     *
     * @param array<K, V> $pairs The associative array to wrap.
     */
    public function __construct(private array $pairs) {}

    /**
     * Wraps an associative array into a {@see Map}.
     *
     * @template L of array-key
     * @template W
     * @param array<L, W> $entries The associative array to wrap.
     * @return self<L, W>
     * @psalm-api
     */
    public static function pairs(array $entries): self
    {
        return new self($entries);
    }

    #[Override]
    public function value(): array
    {
        return $this->pairs;
    }

    #[Override]
    public function count(): int
    {
        return count($this->pairs);
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->pairs;
    }
}
