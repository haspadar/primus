<?php

declare(strict_types=1);

namespace Primus\Func;

use Throwable;

/**
 * {@see Func} with fallback.
 *
 * @template I
 * @template O
 * @extends FuncEnvelope<I, O>
 * @since 0.3
 */
final readonly class FuncWithFallback extends FuncEnvelope
{
    /**
     * @param Func<I, O> $origin
     * @param Func<I, O> $fallback
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
                    } catch (Throwable) {
                        return $fallback->apply($input);
                    }
                }
            )
        );
    }
}
