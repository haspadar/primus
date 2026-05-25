<?php

declare(strict_types=1);

namespace Primus\Func;

use Throwable;

/**
 * Func with fallback.
 *
 * Construction forms:
 *
 * - `new FuncWithFallback(Func, Func)` — wrap the primary and fallback functions.
 * - `FuncWithFallback::ofFunc(Func, Func)` — named-constructor alias of the primary ctor.
 *
 * @template I
 * @template O
 * @extends FuncEnvelope<I, O>
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
                static function ($input) use ($origin, $fallback) {
                    try {
                        return $origin->apply($input);
                        // @phpstan-ignore-next-line haspadar.illegalCatch (fallback catches anything by design)
                    } catch (Throwable) {
                        return $fallback->apply($input);
                    }
                },
            ),
        );
    }

    /**
     * Wraps a primary {@see Func} with a fallback used on exception.
     *
     * @template A
     * @template B
     * @param Func<A, B> $primary The primary function.
     * @param Func<A, B> $rescue The fallback function used on exception.
     * @return self<A, B>
     * @psalm-api
     */
    public static function ofFunc(Func $primary, Func $rescue): self
    {
        return new self($primary, $rescue);
    }
}
