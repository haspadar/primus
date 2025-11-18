<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;
use Primus\Iterator\IteratorOf;

/**
 * Iterable wrapper over a strict PHP list.
 *
 * Example:
 *     $it = new IterableOf([10, 20, 30]);
 *     foreach ($it as $value) {
 *         echo $value . ' ';
 *     }
 *     // 10 20 30
 *
 * @template T
 * @implements IteratorAggregate<T>
 *
 * @since 0.5
 */
final readonly class IterableOf implements IteratorAggregate
{
    /**
     * @param array<mixed,T> $items Strict list of items
     */
    public function __construct(private array $items)
    {
    }

    /**
     * @psalm-return Iterator<mixed, T>
     * @phpstan-return Iterator<mixed, T>
     */
    #[\Override]
    public function getIterator(): Iterator
    {
        return new IteratorOf($this->items);
    }
}
