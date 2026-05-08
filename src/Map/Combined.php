<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\List\List_;
use RuntimeException;

/**
 * Map built from two parallel lists used as keys and values.
 *
 * Pairs are formed by zipping the keys list with the values list at the same positions.
 * Sources of different lengths fail fast on first observation.
 *
 * Example:
 *     $map = new Combined(
 *         new ListOf('a', 'b', 'c'),
 *         new ListOf(1, 2, 3),
 *     );
 *     // ['a' => 1, 'b' => 2, 'c' => 3]
 *
 * @template V
 * @implements Map<array-key, V>
 * @since 0.3
 */
final readonly class Combined implements Map
{
    /**
     * Ctor.
     *
     * @param List_<array-key> $keys Source list of keys.
     * @param List_<V> $values Source list of values, parallel to $keys.
     */
    public function __construct(private List_ $keys, private List_ $values) {}

    #[Override]
    public function value(): array
    {
        $keysArray = array_values($this->keys->value());
        $valuesArray = array_values($this->values->value());

        if (count($keysArray) !== count($valuesArray)) {
            throw new RuntimeException(sprintf(
                'Combined map sources differ in length: %d keys vs %d values',
                count($keysArray),
                count($valuesArray),
            ));
        }

        $pairs = [];

        foreach ($keysArray as $position => $key) {
            $pairs[$key] = $valuesArray[$position];
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
