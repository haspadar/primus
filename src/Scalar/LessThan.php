<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Comparison scalar: checks if left value is less than right.
 *
 * Example:
 *     $scalar = new LessThan(
 *         new ScalarOf(fn() => 3),
 *         new ScalarOf(fn() => 5)
 *     );
 *     echo $scalar->value(); // true
 *
 * @template T of int|float|string
 * @extends ScalarEnvelope<bool>
 * @since 0.2
 */
final readonly class LessThan extends ScalarEnvelope
{
    /**
     * @param Scalar<T> $left
     * @param Scalar<T> $right
     */
    public function __construct(Scalar $left, Scalar $right)
    {
        parent::__construct(
            new ScalarOf(fn (): bool => $left->value() < $right->value())
        );
    }
}
