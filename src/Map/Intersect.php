<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;

/**
 * Map keeping pairs of the first source whose keys are present in every other source.
 *
 * Example:
 *     $intersect = new Intersect(
 *         new MapOf(['a' => 1, 'b' => 2, 'c' => 3]),
 *         new MapOf(['b' => 99, 'c' => 0]),
 *         new MapOf(['c' => 7, 'd' => 1]),
 *     );
 *     // ['c' => 3]
 *
 * @template K of array-key
 * @template V
 * @implements Map<K, V>
 */
final readonly class Intersect implements Map
{
    /** @var array<array-key, Map<K, mixed>> */
    private array $required;

    /**
     * Ctor.
     *
     * @param Map<K, V> $first The map to draw pairs from.
     * @param Map<K, mixed> ...$required Maps whose keys must contain a first-source key for it to be kept.
     */
    public function __construct(private Map $first, Map ...$required)
    {
        $this->required = $required;
    }

    #[Override]
    public function value(): array
    {
        $pairs = [];

        foreach ($this->first->value() as $key => $value) {
            if ($this->presentInAllRequired($key)) {
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

    private function presentInAllRequired(int|string $key): bool
    {
        foreach ($this->required as $source) {
            if (!array_key_exists($key, $source->value())) {
                return false;
            }
        }

        return true;
    }
}
