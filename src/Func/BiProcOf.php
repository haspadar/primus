<?php

declare(strict_types=1);

namespace Primus\Func;

use Closure;
use Override;

/**
 * Wraps a {@see Closure} as a {@see BiProc}.
 *
 * Construction forms:
 *
 * - `new BiProcOf(Closure)` — wrap the given closure.
 * - `BiProcOf::closure(Closure)` — named-constructor alias of the primary ctor.
 *
 * @template X
 * @template Y
 * @implements BiProc<X, Y>
 */
final readonly class BiProcOf implements BiProc
{
    /**
     * Ctor.
     *
     * @param Closure(X, Y): void $origin The closure to wrap.
     */
    public function __construct(private Closure $origin) {}

    /**
     * Wraps a {@see Closure} as a {@see BiProc}.
     *
     * @template A
     * @template B
     * @param Closure(A, B): void $source The closure to wrap.
     * @return self<A, B>
     * @psalm-api
     */
    public static function closure(Closure $source): self
    {
        return new self($source);
    }

    #[Override]
    public function exec(mixed $first, mixed $second): void
    {
        ($this->origin)($first, $second);
    }
}
