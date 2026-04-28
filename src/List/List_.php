<?php

declare(strict_types=1);

namespace Primus\List;

use Countable;
use IteratorAggregate;

/**
 * Represents an ordered list of values.
 *
 * Used for composition and decoration of list-based logic.
 *
 * @template T
 * @extends IteratorAggregate<array-key, T>
 * @since 0.3
 */
interface List_ extends Countable, IteratorAggregate
{
    /**
     * Returns the underlying values as an array.
     *
     * @return array<array-key, T>
     */
    public function value(): array;
}
