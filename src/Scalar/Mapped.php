<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\Func;
use Primus\Func\FuncOf;

/**
 * Mapped {@see Scalar}.
 *
 * Applies a {@see Func} to the value of another {@see Scalar}.
 * Evaluation is lazy: the function is applied only when {@see value()} is called.
 *
 * Example:
 * $scalar = new Mapped(
 *     new FuncOf(fn(int $x): int => $x * 2),
 *     new ScalarOf(new FuncOf(fn(): int => 5))
 * );
 * echo $scalar->value(); // 10
 *
 * @template T
 * @template R
 * @extends ScalarEnvelope<R>
 *
 * @since 0.3
 */
final readonly class Mapped extends ScalarEnvelope
{
    /**
     * @param Func<T, R> $func
     * @param Scalar<T>  $origin
     */
    public function __construct(Func $func, Scalar $origin)
    {
        parent::__construct(
            new ScalarOf(
                new FuncOf(fn (): mixed => $func->apply($origin->value()))
            )
        );
    }
}
