<?php

declare(strict_types=1);

namespace Primus\Func;

use Closure;

/**
 * Wraps a {@see Closure} as a {@see Proc}.
 *
 * @template X
 * @implements Proc<X>
 *
 * @since 0.3
 */
final readonly class ProcOf implements Proc
{
    /**
     * Ctor.
     *
     * @param Closure(X): void $origin The closure to wrap.
     */
    public function __construct(private Closure $origin)
    {
    }

    #[\Override]
    public function exec(mixed $input): void
    {
        ($this->origin)($input);
    }
}
