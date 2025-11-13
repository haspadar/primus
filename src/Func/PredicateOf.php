<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Func;

use Closure;

/**
 * Wraps a {@see Closure} as a {@see Predicate}.
 *
 * @template X
 * @implements Predicate<X>
 *
 * @since 0.3
 */
final readonly class PredicateOf implements Predicate
{
    /** @param Closure(X): bool $origin */
    public function __construct(private Closure $origin)
    {
    }

    #[\Override]
    public function apply(mixed $input): bool
    {
        return ($this->origin)($input);
    }
}
