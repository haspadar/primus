<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use InvalidArgumentException;

/**
 * Logical XOR over multiple {@see Scalar<bool>}.
 *
 * Returns true only if an odd number of conditions are true.
 *
 * Example:
 *     $scalar = new XorOf(
 *         new ScalarOf(fn() => true),
 *         new ScalarOf(fn() => false)
 *     );
 *     echo $scalar->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.2
 */
final readonly class XorOf extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> ...$conditions
     */
    public function __construct(Scalar ...$conditions)
    {
        parent::__construct(
            new ScalarOf(
                fn (): bool => match (count($conditions)) {
                    0 => throw new InvalidArgumentException('XorOf requires at least one condition'),
                    default => array_reduce(
                        $conditions,
                        fn (bool $carry, Scalar $cond): bool => $carry xor $cond->value(),
                        false
                    ),
                }
            )
        );
    }
}
