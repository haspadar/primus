<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;

/**
 * Iterable that forbids NULL values.
 *
 * @template T
 * @implements IteratorAggregate<T>
 *
 * @since 0.5
 */
final readonly class NoNulls implements IteratorAggregate
{
    /**
     * @param Iterator<int, T> $origin
     */
    public function __construct(
        private Iterator $origin
    ) {
    }

    /**
     * @return Iterator<int, T>
     */
    #[\Override]
    public function getIterator(): Iterator
    {
        return new \Primus\Iterator\NoNulls($this->origin);
    }
}
