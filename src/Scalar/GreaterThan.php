<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Comparison scalar: checks if left value is greater than right.
 *
 * Example:
 *     $scalar = new GreaterThan(
 *         new ScalarOf(fn() => 10),
 *         new ScalarOf(fn() => 5)
 *     );
 *     echo $scalar->value(); // true
 *
 * @template T of int|float|string
 * @extends ScalarEnvelope<bool>
 * @since 0.2
 */
final readonly class GreaterThan extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Scalar<T> $left The left operand.
     * @param Scalar<T> $right The right operand.
     */
    public function __construct(Scalar $left, Scalar $right)
    {
        parent::__construct(
            new ScalarOf(static fn(): bool => $left->value() > $right->value()),
        );
    }
}
