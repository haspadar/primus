<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Logical negation of a {@see Scalar<bool>}.
 *
 * Construction forms:
 *
 * - `new Not(Scalar)` — wrap a {@see Scalar<bool>} value.
 * - `Not::ofScalar(Scalar)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $scalar = Not::ofScalar(new ScalarOf(fn() => false));
 *     echo $scalar->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class Not extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Scalar<bool> $origin The scalar to negate.
     */
    public function __construct(Scalar $origin)
    {
        parent::__construct(
            new ScalarOf(static fn(): bool => !$origin->value()),
        );
    }

    /**
     * Negates a {@see Scalar<bool>}.
     *
     * @param Scalar<bool> $scalar The scalar to negate.
     * @psalm-api
     */
    public static function ofScalar(Scalar $scalar): self
    {
        return new self($scalar);
    }
}
