<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\FuncOf;

/**
 * Comparison scalar: checks if left value is less than right.
 *
 * Example:
 *     $scalar = new LessThan(
 *         new ScalarOf(new FuncOf(fn(): int => 3)),
 *         new ScalarOf(new FuncOf(fn(): int => 5))
 *     );
 *     echo $scalar->value(); // true
 *
 * @template T of int|float|string
 * @extends ScalarEnvelope<bool>
 * @since 0.3
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
            new ScalarOf(
                new FuncOf(
                    fn (): bool => $left->value() < $right->value()
                )
            )
        );
    }
}
