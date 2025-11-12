<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Func;

use Override;

/**
 * Envelope for {@see Func}.
 *
 * Delegates {@see apply()} to the wrapped {@see Func}.
 *
 * Example:
 *     $func = new FuncEnvelope(new FuncOf(fn(int $x): int => $x * 2));
 *     echo $func->apply(3); // 6
 *
 * @template I
 * @template O
 * @implements Func<I, O>
 * @since 0.3
 */
abstract readonly class FuncEnvelope implements Func
{
    /**
     * @param Func<I, O> $origin
     */
    public function __construct(private Func $origin)
    {
    }

    /**
     * @param I $input
     * @return O
     */
    #[Override]
    public function apply(mixed $input): mixed
    {
        return $this->origin->apply($input);
    }
}
