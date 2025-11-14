<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Throwable;

/**
 * Cached version of a {@see Scalar}.
 *
 * Evaluates the wrapped scalar once and stores the result in memory.
 * Subsequent calls to {@see value()} return the same cached value.
 *
 * This class is not thread-safe. To share cached data across objects,
 * use an external cache or synchronization mechanism.
 *
 * Example:
 *     $scalar = new Sticky(new ScalarOf(fn() => time()));
 *     echo $scalar->value(); // computed once
 *     echo $scalar->value(); // cached value
 *
 * @template T
 * @implements Scalar<T>
 * @since 0.2
 */
final class Sticky implements Scalar
{
    /**
     * @psalm-suppress NoMutableProperty
     */
    private bool $computed = false;

    /**
     * @var T $stored
     * @psalm-suppress NoMutableProperty
     */
    private $stored;

    /**
     * @param Scalar<T> $origin
     */
    public function __construct(private readonly Scalar $origin)
    {
    }

    /**
     * @throws Throwable
     * @return T
     */
    #[\Override]
    public function value()
    {
        if (!$this->computed) {
            $this->stored = $this->origin->value();
            $this->computed = true;
        }

        return $this->stored;
    }
}
