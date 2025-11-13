<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Func;

use Closure;

/**
 * Wraps a {@see Closure} as a {@see Proc}.
 *
 * @template X
 * @implements Proc<X>
 *
 * @since 0.3
 */
final readonly class ProcOf implements Proc
{
    /** @param Closure(X): void $origin */
    public function __construct(private Closure $origin)
    {
    }

    #[\Override]
    public function exec(mixed $input): void
    {
        ($this->origin)($input);
    }
}
