<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Base class for scalar decorators.
 *
 * Envelope for {@see Scalar}, delegating all calls to the origin.
 * Used as a parent for classes like {@see Sticky} or {@see Ternary}.
 *
 * @template T
 * @implements Scalar<T>
 * @since 0.1
 */
abstract readonly class ScalarEnvelope implements Scalar
{
    /**
     * Ctor.
     *
     * @param Scalar<T> $origin The wrapped scalar.
     */
    public function __construct(protected Scalar $origin)
    {
    }

    #[\Override]
    final public function value()
    {
        return $this->origin->value();
    }
}
