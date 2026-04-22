<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Conditional scalar.
 *
 * Returns {@see $yes} if {@see $condition} evaluates to true,
 * otherwise {@see $no}.
 *
 * Example:
 *     $scalar = new Ternary(
 *         new ScalarOf(fn() => 2 > 1),
 *         new Constant('yes'),
 *         new Constant('no')
 *     );
 *     echo $scalar->value(); // "yes"
 *
 * @template T
 * @extends ScalarEnvelope<T>
 * @since 0.2
 */
final readonly class Ternary extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Scalar<bool> $condition The branching condition.
     * @param Scalar<T> $yes The value returned when condition is true.
     * @param Scalar<T> $no The value returned when condition is false.
     */
    public function __construct(Scalar $condition, Scalar $yes, Scalar $no)
    {
        parent::__construct(
            new ScalarOf(
                fn () => $condition->value() ? $yes->value() : $no->value()
            )
        );
    }
}
