<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Logical AND over multiple {@see Scalar<bool>}.
 *
 * Short-circuits at the first scalar that evaluates to `false` — subsequent
 * scalars are never asked for their value. An empty argument list returns
 * `true` (the identity of conjunction).
 *
 * Example:
 *     $and = new And_(
 *         new Constant(true),
 *         new Constant(false),
 *         new Constant(true),
 *     );
 *     echo $and->value() ? 'all true' : 'something false'; // 'something false'
 *
 *     (new And_())->value(); // true — vacuous truth
 *
 * @extends ScalarEnvelope<bool>
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
                    foreach ($conditions as $condition) {
                        if (!$condition->value()) {
                            return false;
                        }
                    }

                    return true;
                },
            ),
        );
    }
}
