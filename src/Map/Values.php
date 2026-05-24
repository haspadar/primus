<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\List\List_;

/**
 * List of values from a map.
 *
 * Construction forms:
 *
 * - `new Values(Map)` — wrap an existing {@see Map}.
 * - `Values::ofMap(Map)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $values = Values::ofMap(new MapOf(['a' => 1, 'b' => 2]));
 *     // [1, 2]
 *
 * @template K of array-key
 * @template V
 * @implements List_<V>
 */
final readonly class Values implements List_
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map to read values from.
     */
    public function __construct(private Map $origin) {}

    /**
     * Lists values of a {@see Map}.
     *
     * @template L of array-key
     * @template W
     * @param Map<L, W> $map The map to read values from.
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
        return array_values($this->origin->value());
    }

    #[Override]
    public function count(): int
    {
        return $this->origin->count();
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
