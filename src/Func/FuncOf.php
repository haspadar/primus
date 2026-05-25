<?php

declare(strict_types=1);

namespace Primus\Func;

use Closure;
use Override;

/**
 * Wraps a {@see Closure} as a {@see Func}.
 *
 * Construction forms:
 *
 * - `new FuncOf(Closure)` — wrap the given closure.
 * - `FuncOf::closure(Closure)` — named-constructor alias of the primary ctor.
 *
 * @template I
 * @template O
 * @implements Func<I, O>
 */
final readonly class FuncOf implements Func
{
    /**
     * Ctor.
     *
     * @param Closure(I):O $origin The closure to wrap.
     */
    public function __construct(private Closure $origin) {}

    /**
     * Wraps a {@see Closure} as a {@see Func}.
     *
     * @template A
     * @template B
     * @param Closure(A):B $source The closure to wrap.
     * @return self<A, B>
     * @psalm-api
     */
    public static function closure(Closure $source): self
    {
        return new self($source);
    }

    #[Override]
    public function apply($input): mixed
    {
        return ($this->origin)($input);
    }
}
