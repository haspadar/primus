<?php

declare(strict_types=1);

namespace Primus\Func;

use Closure;
use Override;

/**
 * Wraps a {@see Closure} as a {@see Func}.
 *
 * @template I
 * @template O
 * @implements Func<I, O>
 *
 * @since 0.3
 */
final readonly class FuncOf implements Func
{
    /**
     * Ctor.
     *
     * @param Closure(I):O $origin The closure to wrap.
     */
    public function __construct(private Closure $origin) {}

    #[Override]
    public function apply($input): mixed
    {
        return ($this->origin)($input);
    }
}
