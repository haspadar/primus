<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Generator;
use IteratorAggregate;
use Override;
use Primus\Func\Predicate;
use Traversable;

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
 * @implements IteratorAggregate<array-key, T>
 * @since 0.5
 */
final readonly class Filtered implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param Traversable<array-key, T> $origin The origin iterable.
     * @param Predicate<T> $predicate The predicate used to filter values.
     */
    public function __construct(private Traversable $origin, private Predicate $predicate) {}

    #[Override]
    public function getIterator(): Generator
    {
        foreach ($this->origin as $key => $value) {
            if ($this->predicate->apply($value)) {
                yield $key => $value;
            }
        }
    }
}
