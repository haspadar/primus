<?php

declare(strict_types=1);

namespace Primus\Map;

use Generator;
use Override;
use Primus\List\List_;
use Primus\RuntimeException;

/**
 * Map built from two parallel lists used as keys and values.
 *
 * Pairs are formed by zipping the keys list with the values list at the same positions.
 * Sources of different lengths fail fast on first observation.
 *
 * Construction forms:
 *
 * - `new Combined(List_, List_)` — wrap the keys list and the values list.
 * - `Combined::ofLists(List_, List_)` — named-constructor alias of the primary ctor.
 *
 * Example:
 *     $map = Combined::ofLists(
 *         new ListOf('a', 'b', 'c'),
 *         new ListOf(1, 2, 3),
 *     );
 *     // ['a' => 1, 'b' => 2, 'c' => 3]
 *
 * @template V
 * @implements Map<array-key, V>
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

    /**
     * Zips a list of keys with a parallel list of values into a {@see Map}.
     *
     * @template W
     * @param List_<array-key> $names Source list of keys.
     * @param List_<W> $items Source list of values, parallel to $names.
     * @return self<W>
     * @psalm-api
     */
    public static function ofLists(List_ $names, List_ $items): self
    {
        return new self($names, $items);
    }

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

        return array_combine($keysArray, $valuesArray);
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
