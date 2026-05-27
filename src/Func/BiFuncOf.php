<?php

declare(strict_types=1);

namespace Primus\Func;

use Closure;
use Override;

/**
 * Wraps a {@see Closure} as a {@see BiFunc}.
 *
 * Construction forms:
 *
 * - `new BiFuncOf(Closure)` — wrap the given closure.
 * - `BiFuncOf::closure(Closure)` — named-constructor alias of the primary ctor.
 *
 * @template X
 * @template Y
 * @template Z
 * @implements BiFunc<X, Y, Z>
 */
final readonly class BiFuncOf implements BiFunc
{
    /**
     * Ctor.
     *
     * @param Closure(X, Y): Z $origin The closure to wrap.
     */
    public function __construct(private Closure $origin) {}

    /**
     * Wraps a {@see Closure} as a {@see BiFunc}.
     *
     * @template A
     * @template B
     * @template C
     * @param Closure(A, B): C $source The closure to wrap.
     * @return self<A, B, C>
     * @psalm-api
     */
    public static function closure(Closure $source): self
    {
        return new self($source);
    }

    #[Override]
    public function apply(mixed $first, mixed $second): mixed
    {
        return ($this->origin)($first, $second);
    }
}
