<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;

/**
 * Iterable that forbids NULL values.
 *
 * @template T
 * @implements IteratorAggregate<T>
 *
 * @since 0.5
 */
final readonly class NoNulls implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param Iterator<int, T|null> $origin The iterator validated for non-null values; nulls trigger RuntimeException on access.
     */
    public function __construct(
        private Iterator $origin
    ) {
    }

    #[\Override]
    public function getIterator(): Iterator
    {
        return new \Primus\Iterator\NoNulls($this->origin);
    }
}
