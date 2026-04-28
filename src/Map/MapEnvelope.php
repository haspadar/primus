<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Envelope for {@see Map}, delegating all calls to the origin.
 *
 * @template K of array-key
 * @template V
 * @implements Map<K, V>
 * @since 0.3
 */
abstract readonly class MapEnvelope implements Map
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map to delegate to.
     */
    public function __construct(protected Map $origin) {}

    #[Override]
    public function value(): array
    {
        return $this->origin->value();
    }

    #[Override]
    public function count(): int
    {
        return $this->origin->count();
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->origin->getIterator();
    }
}
