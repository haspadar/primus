<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use Override;

/**
 * Base class for {@see Sequence} implementations.
 *
 * @template T
 * @implements Sequence<T>
 */
abstract readonly class SequenceEnvelope implements Sequence
{
    /**
     * @param Sequence<T> $origin
     */
    public function __construct(private Sequence $origin)
    {
    }

    /**
     * @return Iterator<int, T>
     */
    #[Override]
    public function getIterator(): Iterator
    {
        return $this->origin->getIterator();
    }
}
