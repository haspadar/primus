<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Scalar;

use Override;
use Primus\Exception;

/**
 * Cached {@see Scalar}.
 *
 * Evaluates the wrapped scalar once and stores the result in memory.
 * Subsequent calls to {@see value()} return the same value.
 *
 * Example:
 * $time = new Sticky(new ScalarOf(new FuncOf(fn(): int => time())));
 * echo $time->value(); // computed once
 * echo $time->value(); // cached
 *
 * @template T
 * @implements Scalar<T>
 * @since 0.3
 */
final class Sticky implements Scalar
{
    /** @psalm-suppress NoMutableProperty */
    private bool $computed = false;

    /**
     * @var T
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
     * @throws Exception
     * @return T
     */
    #[Override]
    public function value()
    {
        if (!$this->computed) {
            $this->stored = $this->origin->value();
            $this->computed = true;
        }

        return $this->stored;
    }
}
