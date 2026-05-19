<?php

declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Logical XOR over multiple {@see Scalar<bool>}.
 *
 * Returns `true` when an odd number of conditions evaluate to `true`. Unlike
 * AND and OR, XOR cannot short-circuit — every scalar must be inspected to
 * compute the parity. An empty argument list returns `false` (parity zero).
 *
 * Example:
 *     $xor = new Xor_(
 *         new Constant(true),
 *         new Constant(false),
 *     );
 *     echo $xor->value() ? 'odd' : 'even'; // 'odd'
 *
 *     (new Xor_())->value(); // false — empty parity
 *
 * @extends ScalarEnvelope<bool>
 */
final readonly class Xor_ extends ScalarEnvelope
{
    /**
     * Ctor.
     *
     * @param Scalar<bool> ...$conditions The scalars to XOR together.
     */
    public function __construct(Scalar ...$conditions)
    {
        parent::__construct(
            new ScalarOf(
                static function () use ($conditions): bool {
                    $parity = false;

                    foreach ($conditions as $condition) {
                        $parity = ($parity xor $condition->value());
                    }

                    return $parity;
                },
            ),
        );
    }
}
