<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Func;

use Closure;

/**
 * Wraps a {@see Closure} as a {@see BiProc}.
 *
 * @template X
 * @template Y
 * @implements BiProc<X, Y>
 *
 * @since 0.3
 */
final readonly class BiProcOf implements BiProc
{
    /** @param Closure(X, Y): void $origin */
    public function __construct(private Closure $origin)
    {
    }

    #[\Override]
    public function exec(mixed $first, mixed $second): void
    {
        ($this->origin)($first, $second);
    }
}
