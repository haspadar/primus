<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\List\List_;

/**
 * List of keys from a map.
 *
 * Construction forms:
 *
 * - `new Keys(Map)` — wrap an existing {@see Map}.
 * - `Keys::ofMap(Map)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $keys = Keys::ofMap(new MapOf(['a' => 1, 'b' => 2]));
 *     // ['a', 'b']
 *
 * @template K of array-key
 * @template V
 * @implements List_<K>
 */
final readonly class Keys implements List_
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map to read keys from.
     */
    public function __construct(private Map $origin) {}

    /**
     * Lists keys of a {@see Map}.
     *
     * @template L of array-key
     * @template W
     * @param Map<L, W> $map The map to read keys from.
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
        return array_keys($this->origin->value());
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
