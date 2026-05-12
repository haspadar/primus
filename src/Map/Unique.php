<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map with duplicate values removed using strict equality, keys preserved.
 *
 * Only the first occurrence of each distinct value is kept; subsequent
 * entries with the same value are dropped. Values are compared with
 * `===`, so `0` and `'0'` are treated as different. The kept entries
 * retain their original keys from the origin map.
 *
 * Example:
 *     $map = new Unique(new MapOf(['a' => 1, 'b' => 2, 'c' => 1]));
 *     foreach ($map as $key => $value) {
 *         echo "$key=$value ";
 *     }
 *     // a=1 b=2
 *
 * @template K of array-key
 * @template V
 * @extends MapEnvelope<K, V>
 */
final readonly class Unique extends MapEnvelope
{
    #[Override]
    public function value(): array
    {
        $seen = [];
        $kept = [];

        foreach ($this->origin->value() as $key => $item) {
            if (!in_array($item, $seen, true)) {
                $seen[] = $item;
                $kept[$key] = $item;
            }
        }

        return $kept;
    }

    #[Override]
    public function count(): int
    {
        return count($this->value());
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->value();
    }
}
