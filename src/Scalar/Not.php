<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Logical negation of a {@see Scalar<bool>}.
 *
 * Example:
 *     $scalar = new Not(new ScalarOf(fn() => false));
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
}
