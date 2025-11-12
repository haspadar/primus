<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Primus\Func\FuncOf;
use Throwable;

/**
 * Failsafe {@see Scalar}.
 *
 * Executes the wrapped {@see Scalar} and returns its value.
 * If an exception is thrown, returns a fallback value instead.
 *
 * Example:
 * $scalar = new Failsafe(
 *     new ScalarOf(new FuncOf(fn() => throw new \RuntimeException())),
 *     new Constant('fallback')
 * );
 * echo $scalar->value(); // "fallback"
 *
 * @template T
 * @extends ScalarEnvelope<T>
 *
 * @since 0.3
 */
final readonly class ScalarWithFallback extends ScalarEnvelope
{
    /**
     * @param Scalar<T> $origin
     * @param Scalar<T> $fallback
     */
    public function __construct(Scalar $origin, Scalar $fallback)
    {
        parent::__construct(
            new ScalarOf(
                new FuncOf(function () use ($origin, $fallback): mixed {
                    try {
                        return $origin->value();
                    } catch (Throwable) {
                        return $fallback->value();
                    }
                })
            )
        );
    }
}
