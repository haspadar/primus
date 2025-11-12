<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Exception;
use Primus\Func\FuncOf;

/**
 * Logical OR over multiple {@see Scalar<bool>}.
 *
 * Returns true if at least one provided scalar evaluates to true.
 *
 * Example:
 *     $result = new Or_(
 *         new ScalarOf(new FuncOf(fn(): bool => false)),
 *         new ScalarOf(new FuncOf(fn(): bool => true))
 *     );
 *     echo $result->value(); // true
 *
 * @extends ScalarEnvelope<bool>
 * @since 0.3
 */
final readonly class Or_ extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> ...$conditions
     */
    public function __construct(Scalar ...$conditions)
    {
        parent::__construct(
            new ScalarOf(
                new FuncOf(
                    fn (): bool => match (true) {
                        $conditions === [] =>
                            throw new Exception('Or_ requires at least one condition'),
                        default =>
                            array_reduce(
                                $conditions,
                                fn (bool $carry, Scalar $cond): bool
                                    => $carry || $cond->value(),
                                false,
                            ),
                    },
                ),
            ),
        );
    }
}
