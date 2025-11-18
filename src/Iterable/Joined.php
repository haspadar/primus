<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;

/**
 * @template T
 * @implements IteratorAggregate<int, T>
 *
 * @since 0.5
 */
final readonly class Joined implements IteratorAggregate
{
    /**
     * @param array<Iterator<int,T>> $iterators
     */
    public function __construct(
        private array $iterators,
    ) {
    }

    /**
     * @return Iterator<int,T>
     */
    #[\Override]
    public function getIterator(): Iterator
    {
        return new \Primus\Iterator\Joined($this->iterators);
    }
}
