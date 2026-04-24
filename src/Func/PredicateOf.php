<?php

declare(strict_types=1);

namespace Primus\Func;

use Closure;
use Override;

/**
 * Wraps a {@see Closure} as a {@see Predicate}.
 *
 * @template X
 * @implements Predicate<X>
 * @since 0.3
 */
final readonly class PredicateOf implements Predicate
{
    /**
     * Ctor.
     *
     * @param Closure(X): bool $origin The closure to wrap.
     */
    public function __construct(private Closure $origin) {}

    #[Override]
    public function apply(mixed $input): bool
    {
        return ($this->origin)($input);
    }
}
