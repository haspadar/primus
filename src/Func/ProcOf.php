<?php

declare(strict_types=1);

namespace Primus\Func;

use Closure;
use Override;

/**
 * Wraps a {@see Closure} as a {@see Proc}.
 *
 * Construction forms:
 *
 * - `new ProcOf(Closure)` — wrap the given closure.
 * - `ProcOf::closure(Closure)` — named-constructor alias of the primary ctor.
 *
 * @template X
 * @implements Proc<X>
 */
final readonly class ProcOf implements Proc
{
    /**
     * Ctor.
     *
     * @param Closure(X): void $origin The closure to wrap.
     */
    public function __construct(private Closure $origin) {}

    /**
     * Wraps a {@see Closure} as a {@see Proc}.
     *
     * @template A
     * @param Closure(A): void $source The closure to wrap.
     * @return self<A>
     * @psalm-api
     */
    public static function closure(Closure $source): self
    {
        return new self($source);
    }

    #[Override]
    public function exec(mixed $input): void
    {
        ($this->origin)($input);
    }
}
