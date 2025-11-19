<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;
use Primus\Func\Func;

/**
 * Iterable that lazily transforms each element
 * of the origin iterable using the provided function.
 *
 * Example:
 *     $it = new Mapped(
 *         new IterableOf([1, 2, 3]),
 *         new FuncOf(fn (int $x): int => $x * 10)
 *     );
 *
 *     foreach ($it as $value) {
 *         echo $value . ' ';
 *     }
 *     // 10 20 30
 *
 * @template X
 * @template Y
 * @implements IteratorAggregate<Y>
 *
 * @since 0.5
 */
final readonly class Mapped implements IteratorAggregate
{
    /**
     * @param IteratorAggregate<X> $origin
     * @param Func<X, Y> $func
     */
    public function __construct(
        private IteratorAggregate $origin,
        private Func $func,
    ) {
    }

    /**
     * @return Iterator<int, Y>
     */
    #[\Override]
    public function getIterator(): Iterator
    {
        /** @var Iterator<mixed,X> $it */
        $it = $this->origin->getIterator();

        return new \Primus\Iterator\Mapped(
            $it,
            $this->func,
        );
    }
}
