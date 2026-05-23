<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Logical OR over multiple {@see Scalar<bool>}.
 *
 * Short-circuits at the first scalar that evaluates to `true` — subsequent
 * scalars are never asked for their value. An empty argument list returns
 * `false` (the identity of disjunction).
 *
 * Construction forms:
 *
 * - `new Or_(Scalar ...)` — wrap a variadic list of {@see Scalar<bool>}.
 * - `Or_::ofScalars(Scalar ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $or = Or_::ofScalars(
 *         new Constant(false),
 *         new Constant(true),
 *         new Constant(false),
 *     );
 *     echo $or->value() ? 'any true' : 'all false'; // 'any true'
 *
 *     Or_::ofScalars()->value(); // false — no member is true
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
                    foreach ($conditions as $condition) {
                        if ($condition->value()) {
                            return true;
                        }
                    }

                    return false;
                },
            ),
        );
    }

    /**
     * Disjoins variadic {@see Scalar<bool>} conditions.
     *
     * @param Scalar<bool> ...$scalars The scalars to OR together.
     * @psalm-api
     */
    public static function ofScalars(Scalar ...$scalars): self
    {
        return new self(...$scalars);
    }
}
