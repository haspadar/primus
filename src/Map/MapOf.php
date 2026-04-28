<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map built from an associative array.
 *
 * Example:
 *     $map = new MapOf(['a' => 1, 'b' => 2]);
 *     echo count($map); // 2
 *
 * @template K of array-key
 * @template V
 * @implements Map<K, V>
 * @since 0.3
 */
final readonly class MapOf implements Map
{
    /**
     * Ctor.
     *
     * @param array<K, V> $pairs The associative array to wrap.
     */
    public function __construct(private array $pairs) {}

    #[Override]
    public function value(): array
    {
        return $this->pairs;
    }

    #[Override]
    public function count(): int
    {
        return count($this->pairs);
    }

    #[Override]
    public function getIterator(): Generator
    {
        yield from $this->pairs;
    }
}
