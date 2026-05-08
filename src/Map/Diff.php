<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map keeping pairs of the first source whose keys are absent from all other sources.
 *
 * Example:
 *     $diff = new Diff(
 *         new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
 *         new MapOf(['b' => 99]),
 *         new MapOf(['c' => 0]),
 *     );
 *     // ['a' => 1]
 *
 * @template K of array-key
 * @template V
 * @implements Map<K, V>
 * @since 0.3
 */
final readonly class Diff implements Map
{
    /** @var array<array-key, Map<K, mixed>> */
    private array $excluded;

    /**
     * Ctor.
     *
     * @param Map<K, V> $first The map to draw pairs from.
     * @param Map<K, mixed> ...$excluded Maps whose keys remove pairs from the first.
     */
    public function __construct(private Map $first, Map ...$excluded)
    {
        $this->excluded = $excluded;
    }

    #[Override]
    public function value(): array
    {
        $excludedKeys = [];

        foreach ($this->excluded as $source) {
            foreach (array_keys($source->value()) as $key) {
                $excludedKeys[$key] = true;
            }
        }

        $pairs = [];

        foreach ($this->first->value() as $key => $value) {
            if (!array_key_exists($key, $excludedKeys)) {
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
