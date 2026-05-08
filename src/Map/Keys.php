<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\List\List_;

/**
 * List of keys from a map.
 *
 * Example:
 *     $keys = new Keys(new MapOf(['a' => 1, 'b' => 2]));
 *     // ['a', 'b']
 *
 * @template K of array-key
 * @template V
 * @implements List_<K>
 * @since 0.3
 */
final readonly class Keys implements List_
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map to read keys from.
     */
    public function __construct(private Map $origin) {}

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
