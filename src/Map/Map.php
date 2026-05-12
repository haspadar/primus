<?php

declare(strict_types=1);

namespace Primus\Map;

use Countable;
use IteratorAggregate;

/**
 * Represents an associative collection of key-value pairs.
 *
 * Used for composition and decoration of map-based logic.
 *
 * @template K of array-key
 * @template V
 * @extends IteratorAggregate<K, V>
 */
interface Map extends Countable, IteratorAggregate
{
    /**
     * Returns the underlying pairs as an associative array.
     *
     * @return array<K, V>
     */
    public function value(): array;
}
