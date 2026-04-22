<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Closure;
use Override;

/**
 * A scalar created from a closure.
 *
 * Wraps a zero-argument closure and evaluates it lazily when value() is called.
 * This is the primary way to create scalars from deferred computations.
 *
 * The closure is evaluated on every call to value() unless wrapped in a
 * caching decorator like Sticky.
 *
 * Example:
 *     $scalar = new ScalarOf(fn() => 2 + 2);
 *     echo $scalar->value(); // 4
 *
 * @template T
 * @implements Scalar<T>
 * @since 0.1
 */
final readonly class ScalarOf implements Scalar
{
    /**
     * Ctor.
     *
     * @param Closure(): T $closure The deferred computation.
     */
    public function __construct(private Closure $closure)
    {
    }

    #[Override]
    public function value()
    {
        return ($this->closure)();
    }
}
