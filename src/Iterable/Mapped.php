<?php

declare(strict_types=1);

namespace Primus\Iterable;

use Generator;
use IteratorAggregate;
use Override;
use Primus\Func\Func;
use Traversable;

/**
 * Iterable that lazily transforms each element of the origin iterable using the provided function.
 *
 * Example:
 *     $it = new Mapped(
 *         new Iterable_([1, 2, 3]),
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
 * @implements IteratorAggregate<array-key, Y>
 * @since 0.5
 */
final readonly class Mapped implements IteratorAggregate
{
    /**
     * Ctor.
     *
     * @param Traversable<array-key, X> $origin The origin iterable.
     * @param Func<X, Y> $func The function used to transform elements.
     */
    public function __construct(private Traversable $origin, private Func $func) {}

    #[Override]
    public function getIterator(): Generator
    {
        foreach ($this->origin as $key => $value) {
            yield $key => $this->func->apply($value);
        }
    }
}
