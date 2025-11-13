<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Func;

use Closure;

/**
 * Wraps a {@see Closure} as a {@see Func}.
 *
 * @template I
 * @template O
 * @implements Func<I, O>
 *
 * @since 0.3
 */
final readonly class FuncOf implements Func
{
    /**
     * @param Closure(I):O $origin
     */
    public function __construct(private Closure $origin)
    {
    }

    /**
     * @param I $input
     * @return O
     */
    #[\Override]
    public function apply($input): mixed
    {
        return ($this->origin)($input);
    }
}
