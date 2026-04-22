<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;
use Primus\Iterator\IteratorOf;

/**
 * Iterable wrapper over an array of items.
 *
 * Example:
 *     $it = new IterableOf([10, 20, 30]);
 *     foreach ($it as $value) {
 *         echo $value . ' ';
 *     }
 *     // 10 20 30
 *
 * @template T
 * @implements IteratorAggregate<T>
 *
 * @since 0.5
 */
final readonly class IterableOf implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param array<mixed,T> $items The items to iterate over.
     */
    public function __construct(private array $items)
    {
    }

    #[\Override]
    public function getIterator(): Iterator
    {
        return new IteratorOf($this->items);
    }
}
