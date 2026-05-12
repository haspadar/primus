<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Represents a lazily-evaluated value of any type.
 *
 * Serves as a generic interface for deferred computation and value composition.
 * Used as a base abstraction for all primitive-like types (Text, Number, etc).
 *
 * @template-covariant T
 */
interface Scalar
{
    /**
     * Returns the computed value.
     *
     * @noinspection ReturnTypeCanBeDeclaredInspection
     * @return T The value represented by this scalar.
     */
    public function value();
}
