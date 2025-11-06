<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Override;

/**
 * Scalar that always returns the same value.
 *
 * Acts as an eager, immutable source of a predefined value.
 * Unlike {@see ScalarOf}, it performs no computation — the value
 * is provided at construction time and never changes.
 *
 * Example:
 *     $scalar = new Constant(42);
 *     echo $scalar->value(); // 42
 *
 * @template T
 * @implements Scalar<T>
 *
 * @since 0.2
 */
final readonly class Constant implements Scalar
{
    /**
     * @param T $value Value to return on each call.
     */
    public function __construct(private mixed $value)
    {
    }

    /**
     * @return T
     */
    #[Override]
    public function value()
    {
        return $this->value;
    }
}
