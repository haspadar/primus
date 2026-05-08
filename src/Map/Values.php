<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\List\List_;

/**
 * List of values from a map.
 *
 * Example:
 *     $values = new Values(new MapOf(['a' => 1, 'b' => 2]));
 *     // [1, 2]
 *
 * @template K of array-key
 * @template V
 * @implements List_<V>
 * @since 0.3
 */
final readonly class Values implements List_
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map to read values from.
     */
    public function __construct(private Map $origin) {}

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
