<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\FuncOf;

/**
 * Conditional {@see Scalar}.
 *
 * Returns {@see $yes} if {@see $condition} evaluates to true,
 * otherwise {@see $no}.
 *
 * Example:
 * $scalar = new Ternary(
 *     new ScalarOf(new FuncOf(fn(): bool => 2 > 1)),
 *     new Constant('yes'),
 *     new Constant('no')
 * );
 * echo $scalar->value(); // "yes"
 *
 * @template T
 * @extends ScalarEnvelope<T>
 *
 * @since 0.3
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
                new FuncOf(
                    fn (): mixed =>
                $condition->value()
                    ? $yes->value()
                    : $no->value()
                )
            )
        );
    }
}
