<?php

declare(strict_types=1);

namespace Primus\Scalar;

use Throwable;

/**
 * Represents a lazily-evaluated value of any type.
 *
 * Serves as a generic interface for deferred computation and value composition.
 * Used as a base abstraction for all primitive-like types (Text, Number, etc).
 *
 * @template-covariant T
 * @since 0.1
 */
interface Scalar
{
    /**
     * Returns the computed value.
     *
     * @noinspection ReturnTypeCanBeDeclaredInspection
     * @phpstan-ignore-next-line haspadar.illegalThrows
     * @throws Throwable if the value cannot be computed
     * @return T The value represented by this scalar.
     */
    public function value();
}
