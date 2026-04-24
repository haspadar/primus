<?php

declare(strict_types=1);

namespace Primus\Func;

use Closure;
use Override;

/**
 * Wraps a {@see Closure} as a {@see BiFunc}.
 *
 * @template X
 * @template Y
 * @template Z
 * @implements BiFunc<X, Y, Z>
 *
 * @since 0.3
 */
final readonly class BiFuncOf implements BiFunc
{
    /**
     * Ctor.
     *
     * @param Closure(X, Y): Z $origin The closure to wrap.
     */
    public function __construct(private Closure $origin) {}

    #[Override]
    public function apply(mixed $first, mixed $second): mixed
    {
        return ($this->origin)($first, $second);
    }
}
