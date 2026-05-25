<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map of pairs from the first origin whose key/value combinations are absent from all other origins.
 *
 * Values are compared with strict equality (`===`), so `0` and `'0'`
 * are treated as different. Keys are compared by exact match. Only
 * pairs where another origin holds the same key with a strict-equal
 * value are dropped; same key with a different value is kept.
 *
 * Construction forms:
 *
 * - `new DiffAssoc(Map, Map, ...)` — wrap the first map and the excluded maps.
 * - `DiffAssoc::ofMaps(Map, Map, ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $map = DiffAssoc::ofMaps(
 *         new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
 *         new MapOf(['a' => 1, 'b' => 99]),
 *     );
 *     foreach ($map as $key => $value) {
 *         echo "$key=$value ";
 *     }
 *     // b=2 c=3
 *
 * @template K of array-key
 * @template V
 * @implements Map<K, V>
 */
final readonly class DiffAssoc implements Map
{
    /** @var array<array-key, Map<K, V>> */
    private array $excluded;

    /**
     * Ctor.
     *
     * @param Map<K, V> $first The map to draw pairs from.
     * @param Map<K, V> ...$excluded Maps whose key/value pairs remove matches from the first.
     */
    public function __construct(private Map $first, Map ...$excluded)
    {
        $this->excluded = $excluded;
    }

    /**
     * Subtracts pairs whose key/value matches any other {@see Map} from the first map.
     *
     * @template L of array-key
     * @template W
     * @param Map<L, W> $source The map to draw pairs from.
     * @param Map<L, W> ...$removed Maps whose key/value pairs remove matches from the source.
     * @return self<L, W>
     * @psalm-api
     */
    public static function ofMaps(Map $source, Map ...$removed): self
    {
        return new self($source, ...$removed);
    }

    #[Override]
    public function value(): array
    {
        $excludedValues = array_map(
            static fn(Map $source): array => $source->value(),
            $this->excluded,
        );

        $kept = [];

        foreach ($this->first->value() as $key => $value) {
            $matched = false;

            foreach ($excludedValues as $other) {
                if (array_key_exists($key, $other) && $other[$key] === $value) {
                    $matched = true;

                    break;
                }
            }

            if (!$matched) {
                $kept[$key] = $value;
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
