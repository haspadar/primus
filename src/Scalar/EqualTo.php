<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Equality comparison between two {@see Scalar}.
 *
 * Example:
 *     $scalar = new EqualTo(
 *         new ScalarOf(fn() => 5),
 *         new ScalarOf(fn() => 5)
 *     );
 *     echo $scalar->value(); // true
 *
 * @template T
 * @extends ScalarEnvelope<bool>
 * @since 0.2
 */
final readonly class EqualTo extends ScalarEnvelope
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
            new ScalarOf(static fn(): bool => $left->value() === $right->value()),
        );
    }
}
