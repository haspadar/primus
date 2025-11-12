<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Override;
use Primus\Func\Func;

/**
 * A scalar created from a {@see Func}.
 *
 * Wraps a zero-argument function and evaluates it lazily when {@see value()} is called.
 * The function is evaluated on every call unless wrapped in a caching decorator (e.g. Sticky).
 *
 * Example:
 * $scalar = new ScalarOf(new FuncOf(fn(): int => 2 + 2));
 * echo $scalar->value(); // 4
 *
 * @template T
 * @implements Scalar<T>
 * @since 0.3
 */
final readonly class ScalarOf implements Scalar
{
    /** @param Func<mixed, T> $origin */
    public function __construct(private Func $origin)
    {
    }

    #[Override]
    public function value(): mixed
    {
        return $this->origin->apply('');
    }
}
