<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map of pairs from the first origin present in every other origin by key and value.
 *
 * Values are compared with strict equality (`===`), so `0` and `'0'`
 * are treated as different. A pair is kept only when every other
 * origin holds the same key with a strict-equal value; same key with
 * a different value drops the pair.
 *
 * Example:
 *     $map = new IntersectAssoc(
 *         new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
 *         new MapOf(['a' => 1, 'b' => 99, 'c' => 3]),
 *     );
 *     foreach ($map as $key => $value) {
 *         echo "$key=$value ";
 *     }
 *     // a=1 c=3
 *
 * @template K of array-key
 * @template V
 * @implements Map<K, V>
 * @since 0.3
 */
final readonly class IntersectAssoc implements Map
{
    /** @var array<array-key, Map<K, V>> */
    private array $others;

    /**
     * Ctor.
     *
     * @param Map<K, V> $first The map to draw pairs from.
     * @param Map<K, V> ...$others Maps whose key/value pairs must contain a strict-equal copy.
     */
    public function __construct(private Map $first, Map ...$others)
    {
        $this->others = $others;
    }

    #[Override]
    public function value(): array
    {
        $required = array_map(
            static fn(Map $source): array => $source->value(),
            $this->others,
        );

        $kept = [];

        foreach ($this->first->value() as $key => $value) {
            foreach ($required as $other) {
                if (!array_key_exists($key, $other) || $other[$key] !== $value) {
                    continue 2;
                }
            }

            $kept[$key] = $value;
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
