<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Kanstantsin Mesnik
 * SPDX-License-Identifier: MIT
*/
declare(strict_types=1);

namespace Primus\Iterable;

use IteratorAggregate;
use Traversable;

/**
 * A sequence of values that can be iterated in a uniform way.
 *
 * @template T
 * @extends IteratorAggregate<int, T>
 *
 * @since 0.1
 */
interface Sequence extends IteratorAggregate
{
    /**
     * @return \Iterator<int, T>
     */
    #[\Override]
    public function getIterator(): Traversable;
}
