<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;

/**
 * Iterable that joins multiple iterators into a single sequence.
 *
 * @template T
 * @implements IteratorAggregate<int, T>
 *
 * @since 0.5
 */
final readonly class Joined implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param array<Iterator<int,T>> $iterators The iterators to join.
     */
    public function __construct(
        private array $iterators,
    ) {
    }

    #[\Override]
    public function getIterator(): Iterator
    {
        return new \Primus\Iterator\Joined($this->iterators);
    }
}
