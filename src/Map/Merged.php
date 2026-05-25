<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map merged from several source maps with last-wins precedence on key conflicts.
 *
 * Construction forms:
 *
 * - `new Merged(Map, ...)` — wrap the source maps to merge.
 * - `Merged::ofMaps(Map, ...)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $merged = Merged::ofMaps(
 *         new MapOf(['a' => 1, 'b' => 2]),
 *         new MapOf(['b' => 99, 'c' => 3]),
 *     );
 *     // ['a' => 1, 'b' => 99, 'c' => 3]
 *
 * @template K of array-key
 * @template V
 * @implements Map<K, V>
 */
final readonly class Merged implements Map
{
    /** @var array<array-key, Map<K, V>> */
    private array $sources;

    /**
     * Ctor.
     *
     * @param Map<K, V> ...$sources The maps to merge in order; later sources override earlier ones.
     */
    public function __construct(Map ...$sources)
    {
        $this->sources = $sources;
    }

    /**
     * Merges several {@see Map} into one with last-wins precedence on key conflicts.
     *
     * @template L of array-key
     * @template W
     * @param Map<L, W> ...$parts The maps to merge; later sources override earlier ones.
     * @return self<L, W>
     * @psalm-api
     */
    public static function ofMaps(Map ...$parts): self
    {
        return new self(...$parts);
    }

    #[Override]
    public function value(): array
    {
        $pairs = [];

        foreach ($this->sources as $source) {
            foreach ($source->value() as $key => $value) {
                $pairs[$key] = $value;
            }
        }

        return $pairs;
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
