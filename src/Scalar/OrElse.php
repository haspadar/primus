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
 * OrElse {@see Scalar}.
 *
 * Returns the value of the primary {@see Scalar}.
 * If it throws an exception, evaluates and returns the value of the alternative {@see Scalar}.
 *
 * Example:
 * $scalar = new OrElse(
 *     new ScalarOf(new FuncOf(fn() => throw new \RuntimeException('fail'))),
 *     new ScalarOf(new FuncOf(fn() => 'backup'))
 * );
 * echo $scalar->value(); // "backup"
 *
 * @template T
 * @extends ScalarEnvelope<T>
 *
 * @since 0.3
 */
final readonly class OrElse extends ScalarEnvelope
{
    /**
     * @param Scalar<T> $primary
     * @param Scalar<T> $alternative
     */
    public function __construct(Scalar $primary, Scalar $alternative)
    {
        parent::__construct(
            new ScalarOf(
                new FuncOf(function () use ($primary, $alternative): mixed {
                    try {
                        return $primary->value();
                    } catch (Throwable) {
                        return $alternative->value();
                    }
                })
            )
        );
    }
}
