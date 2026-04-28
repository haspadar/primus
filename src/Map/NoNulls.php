<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use RuntimeException;

/**
 * Map that forbids null values.
 *
 * Any access (value, count, foreach) throws when the source map contains
 * a null value, enforcing a non-null invariant by failing fast.
 *
 * @template K of array-key
 * @template V
 * @extends MapEnvelope<K, V>
 * @since 0.3
 */
final readonly class NoNulls extends MapEnvelope
{
    /**
     * Ctor.
     *
     * @param Map<K, V> $origin The map whose null values should be rejected.
     */
    public function __construct(Map $origin)
    {
        parent::__construct($origin);
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
