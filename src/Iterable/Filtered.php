<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Iterable;

/**
 * Filters items in a {@see Sequence} by a predicate.
 *
 * @template T
 * @extends SequenceEnvelope<T>
 */
final class Filtered extends SequenceEnvelope
{
    /**
     * @param callable(T): bool $predicate
     * @param Sequence<T> $sequence
     */
    public function __construct(callable $predicate, Sequence $sequence)
    {
        parent::__construct(new SequenceOf(
            array_values(
                array_filter(
                    iterator_to_array($sequence->getIterator()),
                    $predicate
                )
            )
        ));
    }
}
