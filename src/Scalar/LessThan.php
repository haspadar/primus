<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Comparison scalar: checks if left value is less than right.
 *
 * Example:
 *     $scalar = new LessThan(
 *         new ScalarOf(fn() => 3),
 *         new ScalarOf(fn() => 5)
 *     );
 *     echo $scalar->value(); // true
 *
 * @template T of int|float|string
 * @extends ScalarEnvelope<bool>
 */
final readonly class LessThan extends ScalarEnvelope
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
            new ScalarOf(static fn(): bool => $left->value() < $right->value()),
        );
    }
}
