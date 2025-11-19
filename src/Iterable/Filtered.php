<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Primus\Iterable;

use Iterator;
use IteratorAggregate;
use Primus\Func\Predicate;

/**
 * Iterable that lazily filters values from another iterable
 * using the provided predicate.
 *
 * Example:
 *     $it = new Filtered(
 *         new IterableOf([10, 5, 40, 3]),
 *         new PredicateOf(fn (int $x): bool => $x > 10)
 *     );
 *
 *     foreach ($it as $v) {
 *         echo $v . ' ';   // 40
 *     }
 *
 * @template T
 * @implements IteratorAggregate<T>
 *
 * @since 0.5
 */
final readonly class Filtered implements IteratorAggregate
{
    /**
     * @param IteratorAggregate<T> $origin
     * @param Predicate<T> $predicate
     */
    public function __construct(
        private IteratorAggregate $origin,
        private Predicate $predicate,
    ) {
    }

    /**
     * @throws \Exception
     * @return Iterator<mixed, T>
     */
    #[\Override]
    public function getIterator(): Iterator
    {
        /** @var Iterator<mixed,T> $it */
        $it = $this->origin->getIterator();

        return new \Primus\Iterator\Filtered($it, $this->predicate);
    }
}
