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
 * Example:
 *     $map = new DiffAssoc(
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
 * @since 0.3
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

    #[Override]
    public function value(): array
    {
        $kept = [];

        foreach ($this->first->value() as $key => $value) {
            $matched = false;

            foreach ($this->excluded as $source) {
                $other = $source->value();

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
