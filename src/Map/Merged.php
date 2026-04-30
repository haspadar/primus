<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map merged from several source maps with last-wins precedence on key conflicts.
 *
 * Example:
 *     $merged = new Merged(
 *         new MapOf(['a' => 1, 'b' => 2]),
 *         new MapOf(['b' => 99, 'c' => 3]),
 *     );
 *     // ['a' => 1, 'b' => 99, 'c' => 3]
 *
 * @template K of array-key
 * @template V
 * @implements Map<K, V>
 * @since 0.3
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
