<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Conditional scalar.
 *
 * Returns {@see $truthy} if {@see $condition} evaluates to true,
 * otherwise {@see $falsy}.
 *
 * Construction forms:
 *
 * - `new Ternary(Scalar, Scalar, Scalar)` — wrap a condition and two branches.
 * - `Ternary::ofScalars(Scalar, Scalar, Scalar)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $scalar = Ternary::ofScalars(
 *         new ScalarOf(fn() => 2 > 1),
 *         new Constant('yes'),
 *         new Constant('no')
 *     );
 *     echo $scalar->value(); // "yes"
 *
 * @template T
 * @extends ScalarEnvelope<T>
 */
final readonly class Ternary extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Scalar<bool> $condition The branching condition.
     * @param Scalar<T> $truthy The value returned when condition is true.
     * @param Scalar<T> $falsy The value returned when condition is false.
     */
    public function __construct(Scalar $condition, Scalar $truthy, Scalar $falsy)
    {
        parent::__construct(
            new ScalarOf(
                static fn() => $condition->value() ? $truthy->value() : $falsy->value(),
            ),
        );
    }

    /**
     * Selects one of two {@see Scalar<T>} branches by a {@see Scalar<bool>}.
     *
     * @template U
     * @param Scalar<bool> $condition The branching condition.
     * @param Scalar<U> $truthy The value returned when condition is true.
     * @param Scalar<U> $falsy The value returned when condition is false.
     * @return self<U>
     * @psalm-api
     */
    public static function ofScalars(Scalar $condition, Scalar $truthy, Scalar $falsy): self
    {
        return new self($condition, $truthy, $falsy);
    }
}
