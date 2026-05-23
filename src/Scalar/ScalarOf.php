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
 * Construction forms:
 *
 * - `new ScalarOf(Closure)` — wrap a zero-argument closure.
 * - `ScalarOf::closure(Closure)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $scalar = ScalarOf::closure(fn() => 2 + 2);
 *     echo $scalar->value(); // 4
 *
 * @template T
 * @implements Scalar<T>
 */
final readonly class ScalarOf implements Scalar
{
    /**
     * Ctor.
     *
     * @param Closure(): T $closure The deferred computation.
     */
    public function __construct(private Closure $closure) {}

    /**
     * Wraps a zero-argument {@see Closure} as a deferred {@see Scalar}.
     *
     * @template U
     * @param Closure(): U $body The deferred computation.
     * @return self<U>
     * @psalm-api
     */
    public static function closure(Closure $body): self
    {
        return new self($body);
    }

    #[Override]
    public function value()
    {
        return ($this->closure)();
    }
}
