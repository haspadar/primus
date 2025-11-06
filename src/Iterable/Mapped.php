<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Iterable;

use Closure;

/**
 * A sequence where each item is the result of applying a function to the original items.
 *
 * Example:
 * new Mapped(
 *     fn(int $n): int => $n * 2,
 *     new SequenceOf([1, 2, 3])
 * );
 *
 * @template TIn
 * @template TOut
 * @extends SequenceEnvelope<TOut>
 */
final readonly class Mapped extends SequenceEnvelope
{
    /**
     * @param Closure(TIn): TOut $fn
     * @param Sequence<TIn> $sequence
     */
    public function __construct(Closure $fn, Sequence $sequence)
    {
        parent::__construct(new SequenceOf(
            array_values(array_map($fn, iterator_to_array($sequence->getIterator())))
        ));
    }
}
