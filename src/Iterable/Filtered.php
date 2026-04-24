<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;
use Override;
use Primus\Func\Predicate;
use Primus\Iterator\Filtered as FilteredIterator;

/**
 * Iterable that lazily filters values from another iterable using the provided predicate.
 *
 * Example:
 *     $it = new Filtered(
 *         new IterableOf([10, 5, 40, 3]),
 *         new PredicateOf(fn (int $x): bool => $x > 10)
 *     );
 *
 *     foreach ($it as $v) {
 *         echo $v . ' '; // 40
 *     }
 *
 * @template T
 * @implements IteratorAggregate<T>
 * @since 0.5
 */
final readonly class Filtered implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param IteratorAggregate<T> $origin The origin iterable.
     * @param Predicate<T> $predicate The predicate used to filter values.
     */
    public function __construct(private IteratorAggregate $origin, private Predicate $predicate) {}

    #[Override]
    public function getIterator(): Iterator
    {
        /** @var Iterator<mixed, T> $iterator */
        $iterator = $this->origin->getIterator();

        return new FilteredIterator($iterator, $this->predicate);
    }
}
