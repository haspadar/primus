<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\RuntimeException;

/**
 * Map that forbids null values.
 *
 * Any access (value, count, foreach) throws when the source map contains
 * a null value, enforcing a non-null invariant by failing fast.
 *
 * Construction forms:
 *
 * - `new NoNulls(Map)` — wrap an existing {@see Map}.
 * - `NoNulls::ofMap(Map)` — named-constructor alias of the primary ctor.
 *
 * @template K of array-key
 * @template V
 * @extends MapEnvelope<K, V>
 */
final readonly class NoNulls extends MapEnvelope
{
    /**
     * Forbids null values in a {@see Map}, throwing on access when one is found.
     *
     * @template L of array-key
     * @template W
     * @param Map<L, W> $map The map to guard against nulls.
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
        return iterator_to_array($this->getIterator());
    }

    #[Override]
    public function count(): int
    {
        return count($this->value());
    }

    #[Override]
    public function getIterator(): Generator
    {
        foreach ($this->origin->value() as $key => $value) {
            if ($value === null) {
                throw new RuntimeException('Null value encountered in NoNulls map');
            }

            yield $key => $value;
        }
    }
}
