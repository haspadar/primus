<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Iterable;

use ArrayIterator;
use Iterator;

/**
 * A sequence backed by a PHP array.
 *
 * Example:
 * $seq = new SequenceOf(['a', 'b', 'c']);
 * foreach ($seq as $item) {
 *     echo $item; // a b c
 * }
 *
 * @template T
 * @implements Sequence<T>
 * @psalm-pure
 * @since 0.1
 */
final readonly class SequenceOf implements Sequence
{
    /** @var list<T> */
    private array $items;

    /**
     * @param list<T> $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /** @return Iterator<int, T> */
    #[\Override]
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Returns the underlying array.
     *
     * @return list<T>
     */
    public function value(): array
    {
        return $this->items;
    }
}
