<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Checks if a {@see Scalar} value lies strictly between two bounds.
 *
 * Example:
 *     $scalar = new Between(
 *         new ScalarOf(new FuncOf(fn(): int => 5)),
 *         new ScalarOf(new FuncOf(fn(): int => 1)),
 *         new ScalarOf(new FuncOf(fn(): int => 10))
 *     );
 *     echo $scalar->value(); // true
 *
 * @template T of int|float|string
 * @extends ScalarEnvelope<bool>
 * @since 0.3
 */
final readonly class Between extends ScalarEnvelope
{
    /**
     * @param Scalar<T> $value
     * @param Scalar<T> $lower
     * @param Scalar<T> $upper
     */
    public function __construct(Scalar $value, Scalar $lower, Scalar $upper)
    {
        parent::__construct(
            new And_(
                new GreaterThan($value, $lower),
                new LessThan($value, $upper),
            ),
        );
    }
}
