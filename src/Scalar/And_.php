<?php

declare(strict_types=1);

namespace Primus\Scalar;

use InvalidArgumentException;

/**
 * Logical AND over multiple {@see Scalar<bool>}.
 *
 * Returns true only if all provided scalars evaluate to true.
 *
 * Example:
 *     $and = new And_(new True_(), new False_());
 *     echo $and->value(); // false
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.2
 */
final readonly class And_ extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Scalar<bool> ...$conditions The scalars to AND together.
     */
    public function __construct(Scalar ...$conditions)
    {
        parent::__construct(
            new ScalarOf(
                static function () use ($conditions): bool {
                    if ($conditions === []) {
                        throw new InvalidArgumentException('And_ requires at least one condition');
                    }

                    return array_reduce(
                        $conditions,
                        static fn(bool $carry, Scalar $cond): bool => $carry && $cond->value(),
                        true,
                    );
                },
            ),
        );
    }
}
