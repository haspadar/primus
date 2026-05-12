<?php

declare(strict_types=1);

namespace Primus\Scalar;

use InvalidArgumentException;

/**
 * Logical OR over multiple {@see Scalar<bool>}.
 *
 * Returns true if at least one provided scalar evaluates to true.
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class Or_ extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Scalar<bool> ...$conditions The scalars to OR together.
     */
    public function __construct(Scalar ...$conditions)
    {
        parent::__construct(
            new ScalarOf(
                static function () use ($conditions): bool {
                    if ($conditions === []) {
                        throw new InvalidArgumentException('Or requires at least one condition');
                    }

                    return array_any($conditions, static fn($condition) => $condition->value());
                },
            ),
        );
    }
}
