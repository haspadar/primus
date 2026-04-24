<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Generator;
use IteratorAggregate;
use Override;
use Traversable;

/**
 * Iterable that joins multiple iterables into a single sequence.
 *
 * @template T
 * @implements IteratorAggregate<int, T>
 * @since 0.5
 */
final readonly class Joined implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param list<Traversable<mixed, T>> $iterators The iterables to join.
     */
    public function __construct(private array $iterators) {}

    #[Override]
    public function getIterator(): Generator
    {
        $position = 0;

        foreach ($this->iterators as $iterator) {
            foreach ($iterator as $value) {
                yield $position => $value;

                $position++;
            }
        }
    }
}
