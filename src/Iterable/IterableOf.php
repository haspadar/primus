<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Generator;
use IteratorAggregate;
use Override;

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
 * @implements IteratorAggregate<array-key, T>
 * @since 0.5
 */
final readonly class IterableOf implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param array<array-key, T> $items The items to iterate over.
     */
    public function __construct(private array $items) {}

    #[Override]
    public function getIterator(): Generator
    {
        foreach ($this->items as $key => $value) {
            yield $key => $value;
        }
    }
}
