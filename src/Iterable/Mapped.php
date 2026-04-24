<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;
use Override;
use Primus\Func\Func;

/**
 * Iterable that lazily transforms each element of the origin iterable using the provided function.
 *
 * Example:
 *     $it = new Mapped(
 *         new IterableOf([1, 2, 3]),
 *         new FuncOf(fn (int $x): int => $x * 10)
 *     );
 *
 *     foreach ($it as $value) {
 *         echo $value . ' ';
 *     }
 *     // 10 20 30
 *
 * @template X
 * @template Y
 * @implements IteratorAggregate<Y>
 *
 * @since 0.5
 */
final readonly class Mapped implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param IteratorAggregate<X> $origin The origin iterable.
     * @param Func<X, Y> $func The function used to transform elements.
     */
    public function __construct(
        private IteratorAggregate $origin,
        private Func $func,
    ) {}

    #[Override]
    public function getIterator(): Iterator
    {
        /** @var Iterator<mixed, X> $iterator */
        $iterator = $this->origin->getIterator();

        return new \Primus\Iterator\Mapped(
            $iterator,
            $this->func,
        );
    }
}
