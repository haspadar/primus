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
 * ThrowsIf {@see Scalar}.
 *
 * Throws an exception if the given condition is true.
 * Otherwise returns the value of the wrapped {@see Scalar}.
 *
 * Example:
 * $scalar = new ThrowsIf(
 *     new ScalarOf(new FuncOf(fn(): bool => true)),
 *     new Constant('ok'),
 *     new \RuntimeException('Condition failed')
 * );
 * $scalar->value(); // throws RuntimeException
 *
 * @template T
 * @extends ScalarEnvelope<T>
 *
 * @since 0.3
 */
final readonly class ThrowsIf extends ScalarEnvelope
{
    /**
     * @param Scalar<bool> $condition
     * @param Scalar<T> $origin
     */
    public function __construct(Scalar $condition, Scalar $origin, Throwable $exception)
    {
        parent::__construct(
            new ScalarOf(
                new FuncOf(function () use ($condition, $origin, $exception): mixed {
                    if ($condition->value()) {
                        throw $exception;
                    }
                    return $origin->value();
                })
            )
        );
    }
}
