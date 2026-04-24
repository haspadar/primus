<?php

declare(strict_types=1);

namespace Primus\Func;

use Exception;

/**
 * Func with fallback.
 *
 * @template I
 * @template O
 * @extends FuncEnvelope<I, O>
 * @since 0.3
 */
final readonly class FuncWithFallback extends FuncEnvelope
{
    /**
     * Ctor.
     *
     * @param Func<I, O> $origin The primary function.
     * @param Func<I, O> $fallback The fallback function used on exception.
     */
    public function __construct(Func $origin, Func $fallback)
    {
        parent::__construct(
            new FuncOf(
                /**
                 * @param I $input
                 * @return O
                 */
                function ($input) use ($origin, $fallback) {
                    try {
                        return $origin->apply($input);
                    } catch (Exception) { // @phpstan-ignore haspadar.illegalCatch
                        return $fallback->apply($input);
                    }
                }
            )
        );
    }
}
