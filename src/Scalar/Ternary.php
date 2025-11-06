<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

/**
 * Conditional scalar.
 *
 * Returns {@see $yes} if {@see $condition} evaluates to true,
 * otherwise {@see $no}.
 *
 * Example:
 *     $scalar = new Ternary(
 *         new ScalarOf(fn() => 2 > 1),
 *         new Constant('yes'),
 *         new Constant('no')
 *     );
 *     echo $scalar->value(); // "yes"
 *
 * @template T
 * @extends ScalarEnvelope<T>
 * @since 0.2
 */
final readonly class Ternary extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> $condition
     * @param Scalar<T> $yes
     * @param Scalar<T> $no
     */
    public function __construct(Scalar $condition, Scalar $yes, Scalar $no)
    {
        parent::__construct(
            new ScalarOf(
                fn () => $condition->value() ? $yes->value() : $no->value()
            )
        );
    }
}
