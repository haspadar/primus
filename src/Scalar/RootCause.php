<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Override;
use Throwable;

/**
 * Deepest cause of a Throwable chain.
 *
 * Walks getPrevious() until a Throwable without a previous one is reached and
 * returns it. For a Throwable without any cause, returns the input itself.
 *
 * Construction forms:
 *
 * - `new RootCause(Throwable)` — wrap an existing Throwable.
 * - `RootCause::ofThrowable(Throwable)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $root = RootCause::ofThrowable($outer);
 *     $root->value(); // the innermost Throwable in the chain
 *
 * @implements Scalar<Throwable>
 */
final readonly class RootCause implements Scalar
{
    /**
     * Ctor.
     *
     * @param Throwable $origin The Throwable whose chain to unwrap.
     */
    public function __construct(private Throwable $origin) {}

    /**
     * Unwraps a Throwable chain to its deepest cause.
     *
     * @param Throwable $throwable The Throwable whose chain to unwrap.
     * @psalm-api
     */
    public static function ofThrowable(Throwable $throwable): self
    {
        return new self($throwable);
    }

    #[Override]
    public function value(): Throwable
    {
        $cause = $this->origin;

        for ($previous = $cause->getPrevious(); $previous !== null; $previous = $cause->getPrevious()) {
            $cause = $previous;
        }

        return $cause;
    }
}
