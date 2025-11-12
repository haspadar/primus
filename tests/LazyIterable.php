<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Tests;

use Generator;
use IteratorAggregate;

/**
 * Stub iterable used to verify lazy iteration behavior in tests.
 *
 * @template T
 * @implements IteratorAggregate<int, T>
 *
 * @internal
 */
final class LazyIterable implements IteratorAggregate
{
    private bool $started = false;

    /** @param list<T> $values */
    public function __construct(private readonly array $values)
    {
    }

    public function getIterator(): Generator
    {
        $this->started = true;
        foreach ($this->values as $v) {
            yield $v;
        }
    }

    public function started(): bool
    {
        return $this->started;
    }
}
