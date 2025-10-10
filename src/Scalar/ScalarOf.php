<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

/**
 * A scalar that wraps a deferred computation.
 *
 * Accepts a lazily evaluated value via a closure and returns it upon demand.
 * Serves as the main entry point for functional scalar composition.
 *
 * Example:
 * $scalar = new ScalarOf(fn() => 2 + 2);
 * echo $scalar->value(); // 4
 *
 * @template T
 * @implements Scalar<T>
 * @psalm-pure
 * @since 0.1
 */
final readonly class ScalarOf implements Scalar
{
    /**
     * @param \Closure(): T $value
     */
    public function __construct(
        private \Closure $value
    ) {
    }

    /**
     * @return T
     */
    #[\Override]
    public function value(): mixed
    {
        return ($this->value)();
    }
}
